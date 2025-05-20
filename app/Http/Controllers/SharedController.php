<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class SharedController extends Controller
{
    public function indexUser() {

        $reviews = Review::with('client')->inRandomOrder()->limit(3)->get();
        $drivers = User::where('role_id', 2)->where('gotRegistered', "accepted")->limit(3)->get();
        return view("UserHomeView", compact("reviews", "drivers"));
    }

    public function indexAdmin() {
        return view("AdminHomeView");
    }
    public function indexDriver() {
        return view("DriverHomeView");
    }

    public function AboutUs() {
        return view("AboutUsSection");
    }

    public function ContactUs() {
        return view("ContactUsSection");
    }
}
