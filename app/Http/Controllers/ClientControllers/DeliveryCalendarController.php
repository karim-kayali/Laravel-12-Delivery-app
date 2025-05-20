<?php

namespace App\Http\Controllers\ClientControllers;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DeliveryCalendarController extends Controller
{
    public function index()
    {
        return view('ClientViews.Calendar');
    }

    public function fetchDeliveries()
    {
        $user = Auth::user();

        $query = Delivery::query()
            ->where(function ($q) use ($user) {
                $q->where('deliveredTo', $user->id)
                    ->orWhere('deliveredBy', $user->id);
            })
            ->whereHas('request', function ($q) {
                $q->where('requestStatus', 'accepted');
            })
            ->where(function ($q) {
                $q->whereHas('statuses', function ($subQuery) {
                    $subQuery->where('deliveryStatus', 'inProgress');
                })
                    ->orDoesntHave('statuses');
            });

        $deliveries = $query->get();

        foreach ($deliveries as $delivery) {
            $hasStatus = Status::where('delivery_id', $delivery->id)->exists();

            if (!$hasStatus && Carbon::parse($delivery->scheduledDeliveryDate)->isPast()) {
                Status::create([
                    'delivery_id' => $delivery->id,
                    'deliveryStatus' => 'inProgress',
                    'token' => 'valid',
                ]);
            }
        }

        $events = $deliveries->map(function ($delivery) {
            $deliveredByName = User::find($delivery->deliveredBy)->userName ?? 'Unknown Driver';
            $deliveredToName = User::find($delivery->deliveredTo)->userName ?? 'Unknown Customer';

            return [
                'id' => $delivery->id,
                'title' => 'Delivery #' . $delivery->id,
                'start' => Carbon::parse($delivery->scheduledDeliveryDate)->toIso8601String(),
                'scheduledDate' => Carbon::parse($delivery->scheduledDeliveryDate)->toDateString(), // ← Add this
                'extendedProps' => [
                    'deliveredBy' => $delivery->deliveredBy,
                    'deliveredTo' => $delivery->deliveredTo,
                    'deliveredByName' => $deliveredByName,
                    'deliveredToName' => $deliveredToName,
                ],
            ];
        });

        return response()->json($events);
    }


}
