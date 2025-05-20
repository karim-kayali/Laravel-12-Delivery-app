<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminApplicationsController extends Controller
{


    public function manageDriverView()
    {
        $message = "Choose application type";
    return view('AdminViews/ManageDrivers', compact('message'));
    }

    public function manageDriverViewDrop($gotRegistered) {
        $drivers = User::where('role_id', 2)->where('gotRegistered', $gotRegistered)->get();
        $status = $gotRegistered;
        if($drivers->isEmpty()) {
            $emptyMessage = "no users to be listed";
            return view('AdminViews/ManageDrivers', compact('drivers', 'status', 'emptyMessage'));
        }

        return view('AdminViews/ManageDrivers', compact('drivers', 'status'));
//        return response()->json($drivers);
    }


    public function acceptDriver($id) {
        $driver = User::find($id);

        if($driver) {
            $driver->gotRegistered = "accepted";
            $driver->save();
            return redirect()->route('indexAdmin');
        }


    }

    public function rejectDriver($id) {
        $driver = User::find($id);

        if($driver) {
        $driver->gotRegistered = "rejected";
        $driver->save();
        return redirect()->route('indexAdmin');
            }
    }

    public function displayDriverDetails($id) {
        $driver = User::find($id);

        if($driver) {
            return view('AdminViews/ManageDriverDetails', compact('driver'));
        }

    }

    public function getMaps($id) {
        $delivery = Delivery::with('deliveredByUser', 'deliveredToUser')->findOrFail($id);


        if((Auth::user()->id == $delivery->deliveredByUser->id) || (Auth::user()->id == $delivery->deliveredToUser->id)) {

            return view('AdminViews/TestingMaps', [
                'delivery' => $delivery,
                'isDriver' => Auth::user()->role_id == 2,
            ]);
        }
        else {
            return abort(403);
        }

    }

//
}
