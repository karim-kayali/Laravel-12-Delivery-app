<?php

namespace App\Http\Controllers\ClientControllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $driverId)
    {
        
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|max:255',
        ]);

        
        Review::create([
            'driver_id' => $driverId,
            'client_id' => Auth::user()->id, //assuming that the logged in user is a client
            'rating' => $request->rating,
            'ReviewDescription' => $request->review_text,
        ]);

        return redirect()->route('DriverDetails', $driverId)->with('success', 'Review added successfully!');
    }
}
