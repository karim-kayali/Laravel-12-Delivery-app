<?php

namespace App\Http\Controllers\DriverControllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class DriverReviewController extends Controller
{
    public function viewOwnReviews() {
        $reviews = Review::with('client')->where('driver_id', Auth::user()->id)->get();

        return view('DriverViews/DriverOwnReview', compact('reviews'));

    }
}
