<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Request;
use Illuminate\Support\Facades\Log;

class AdminTrackDeliveries extends Controller
{
    public function adminTrackDeliveriesView()
    {
        $message = "Choose Delivery type";
        return view('AdminViews/TrackDeliveries', compact('message'));
    }

    public function adminTrackDeliveriesViewDrop($requestStatus)
    {
        error_log('Full request: ' . $requestStatus);


        $deliveries = Delivery::with('request', 'deliveredToUser', 'deliveredByUser','statuses')
            ->whereHas('request', function ($q) use ($requestStatus) {
                $q->where('requestStatus', $requestStatus);
            })->orWhereHas('statuses', function ($q) use ($requestStatus) {
                $q->where('deliveryStatus', $requestStatus);
            })
            ->get();

        $request = $requestStatus;
        if($deliveries->isEmpty()) {
            $emptyRequestMessage = "no deliveries to be listed";
            return view('AdminViews/TrackDeliveries', compact('deliveries', 'request', 'emptyRequestMessage'));
        }
        return view('AdminViews/TrackDeliveries', compact('deliveries', 'request'));
    }

    public function displayDeliveryDetails($id) {
        $delivery = Delivery::with('request', 'deliveredToUser', 'deliveredByUser')->findOrFail($id);

        return view('AdminViews/TrackDeliveryDetails', compact('delivery'));


    }











}
