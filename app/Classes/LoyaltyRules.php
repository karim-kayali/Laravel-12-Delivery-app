<?php

namespace App\Classes;

use App\Models\Delivery;
use App\Models\Status;
use App\Models\User;

class LoyaltyRules
{

    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }

    public function getDeliveryStatus($id)
    {
        $status =  Status::where('delivery_id', $id)->latest()->first();

        if (!$status) {
            return response()->json(['error' => 'Status not found'], 404);
        }

        return response()->json([
            'deliveryStatus' => $status->deliveryStatus
        ]);
    }



    public function completeDelivery($deliveryId)
    {
        $delivery = Delivery::findOrFail($deliveryId);
        $status = Status::where('delivery_id', $deliveryId)->latest()->first(); // assuming latest status

        $status->deliveryStatus='completed';
        $status->save();

        $result = $this->addingLoyaltyPoints(
            $delivery->pickedFromY,
            $delivery->pickedFromX,
            $delivery->destinationY,
            $delivery->destinationX,
            $delivery->deliveredTo,
            $status->id
        );

        if ($result) {
            return redirect()->route('ReturnHomePage');
        } else {
            return view('PageExpired');
        }
    }



    public function addingLoyaltyPoints($lat1, $lon1, $lat2, $lon2, $deliveredTo, $statusId) {
        $totalDistance = $this->calculateDistance($lat1, $lon1, $lat2, $lon2);

        $totalPoints = $totalDistance * 2;
        $token = Status::findOrFail($statusId);
        if($token->token == 'valid') {
            $user = User::findOrFail($deliveredTo);
            $user->points = $user->points + $totalPoints;
            $user->save();
            $token->token = 'invalid';
            $token->save();


        return redirect()->route('indexUser');
        } else {
            return false;
           return view('PageExpired');
        }


    }

}
