<?php

namespace App\Http\Controllers\ClientControllers;

use App\Http\Controllers\Controller;
use App\Models\Delivery;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ClientDeliveryController extends Controller
{
    public function ShowPendingDeliveries()
    {

        // For now, we're using a user with ID 1 (role_id 1)
        $user = User::find(Auth::user()->id);  // Using user id 1

        // Check if the user has the role_id of 1 (regular client)


            $pendingDeliveries = Delivery::whereHas('request', function ($query) {
                $query->where('requestStatus', 'pending');
            })
                ->where('deliveredTo', $user->id) // Only deliveries where the user is the recipient
                ->with('request', 'deliveredToUser', 'deliveredByUser') // Load related user data
                ->get();


            return view('ClientViews.PendingDeliveriesView', compact('pendingDeliveries'));

        }







}
