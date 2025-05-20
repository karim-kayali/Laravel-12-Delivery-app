<?php

namespace App\Http\Controllers\ClientControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class DriverController extends Controller
{
    // Display all drivers
    public function index()
    {
        $drivers = User::where('role_id', 2)->where('gotRegistered','accepted')->get();
        return view('ClientViews.BrowseDrivers', compact('drivers'));
    }

    //driver details
    public function show($id)
    {
        $driver = User::findOrFail($id);
        $reviews = $driver->reviews()->with('client')->get();
        return view('ClientViews.DriverDetails', compact('driver', 'reviews'));
    }
}
