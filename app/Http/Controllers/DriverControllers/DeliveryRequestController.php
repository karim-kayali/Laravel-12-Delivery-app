<?php

namespace App\Http\Controllers\DriverControllers;
use App\Notifications\DeliveryPushNotification2;
use App\Models\User;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Request as DeliveryRequest;
use App\Http\Controllers\Controller;

class DeliveryRequestController extends Controller
{
    // Check user role and registration status
    private function checkUserStatus()
    {
        $user = auth()->user();

        // Check if user is a driver
        if ($user->role_id !== 2) {
            abort(403, 'Unauthorized.');
        }

        // Check the user's registration status
        if ($user->gotRegistered === 'pending') {
            return redirect()->route('PendingDriverPage');
        }

        if ($user->gotRegistered === 'rejected') {
            return redirect()->route('RejectedDriverPage');
        }

        return null; // If everything is fine, return null
    }

    public function RejectedDriverPageFunction()
    {
        return view('DriverViews.RejectedDriver');
    }

    public function PendingDriverPageFunction()
    {
        return view('DriverViews.WaitingConfirmation');
    }

    // Show pending deliveries
    public function showPendingDeliveries(Request $request)
    {
        $checkStatusResponse = $this->checkUserStatus();
        if ($checkStatusResponse) {
            return $checkStatusResponse;
        }

        $statusFilter = $request->query('status');

        $query = Delivery::with(['deliveredToUser', 'deliveredByUser'])
            ->where('deliveredBy', auth()->id())
            ->where(function ($query) use ($statusFilter) {
                if ($statusFilter === 'completed') {
                    $query->whereHas('request', function ($q) {
                        $q->where('requestStatus', 'accepted');
                    })
                        ->whereHas('statuses', function ($q) {
                            $q->where('deliveryStatus', 'completed');
                        });
                } elseif ($statusFilter === 'accepted' || $statusFilter === 'pending') {
                    $query->whereHas('request', function ($q) use ($statusFilter) {
                        $q->where('requestStatus', $statusFilter);
                    });
                } else {
                    $query->whereHas('request', function ($q) {
                        $q->where('requestStatus', 'pending');
                    });
                }
            });

        $pendingDeliveries = $query->get();

        $totalPrice = 0;
        if ($statusFilter === 'completed') {
            $totalPrice = $pendingDeliveries->sum('totalDeliveryPrice');
        }

        return view('DriverViews.pendingDeliveries', compact('pendingDeliveries', 'totalPrice', 'statusFilter'));
    }

    // Accept delivery request
    public function acceptDelivery($deliveryId)
    {
        // Check user status and return appropriate response if needed
        $checkStatusResponse = $this->checkUserStatus();
        if ($checkStatusResponse) {
            return $checkStatusResponse;
        }

        $delivery = Delivery::find($deliveryId);

        if (!$delivery) {
            return redirect()->route('deliveries.pending')->with('error', 'Delivery not found');
        }

        $request = $delivery->request;

        if ($request) {
            $request->update(['requestStatus' => 'accepted']);



            return redirect()->route('calendar')
                ->with('success', 'Delivery accepted.')
                ->with('refresh_deliveries', true);
        }

        return redirect()->route('deliveries.pending')->with('error', 'Request not found');
    }

    // Reject delivery request


    public function rejectDelivery($deliveryId)
    {
        // Check user status and return appropriate response if needed
        $checkStatusResponse = $this->checkUserStatus();
        if ($checkStatusResponse) {
            return $checkStatusResponse;
        }

        // Find the delivery by its ID
        $delivery = Delivery::find($deliveryId);

        if (!$delivery) {
            return redirect()->route('deliveries.pending')->with('error', 'Delivery not found');
        }

        // Get the associated request for the delivery
        $request = $delivery->request;

        if ($request) {

            $user = $delivery->deliveredToUser;

            // Get the discount value from the delivery table
            $discount = $delivery->discount;

            // Check if discount is valid and refund points if applicable
            if ($discount == 15) {
                $user->points += 150; // Refund 150 points for 15% discount
            } elseif ($discount == 20) {
                $user->points += 250; // Refund 250 points for 20% discount
            } elseif ($discount == 30) {
                $user->points += 400; // Refund 400 points for 30% discount
            }
            // If there's no discount, skip the refund logic but still proceed with rejection
            // You don't need to return an error for no discount.

            // Save the updated points in the users table (if discount was applied)
            if ($discount !== null) {
                $user->save();
            }

            // Update the request status to 'denied'
            $request->update(['requestStatus' => 'denied']);

            // Redirect back with a success message
            return redirect()->route('deliveries.pending')->with('success', 'Delivery rejected and points refunded (if applicable).');
        }

        return redirect()->route('deliveries.pending')->with('error', 'Request not found');
    }


    // Show delivery details
    public function showDeliveryDetails($id)
    {
        $checkStatusResponse = $this->checkUserStatus();
        if ($checkStatusResponse) {
            return $checkStatusResponse;
        }

        $delivery = Delivery::with(['deliveredToUser', 'deliveredByUser', 'request', 'statuses'])
            ->where('id', $id)
            ->where('deliveredBy', auth()->id())
            ->first();

        if (!$delivery) {
            return redirect()->route('deliveries.pending')->with('error', 'Delivery not found or not assigned to you.');
        } else if($delivery->deliveredByUser->id == auth()->id()) {
            return view('DriverViews.deliveryDetails', compact('delivery'));
        } else {
            return abort(403);
        }


    }

}
