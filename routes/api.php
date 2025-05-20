<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::post('/update-driver-location', function (Request $request) {
    $coords = $request->only(['lat', 'lng']);
    Cache::put('driver_location', $coords, 300); // store for 5 min
    return response()->json(['status' => 'ok']);
});
Route::get('/get-driver-location', function () {
    $coords = Cache::get('driver_location', null);

    if (!$coords) {
        return response()->json(['error' => 'No location found'], 404);
    }

    return response()->json($coords);
});
