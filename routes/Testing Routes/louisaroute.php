<?php

use App\Http\Controllers\SharedController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\GitHubController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\ClientControllers\ProfileController;
use App\Http\Controllers\ClientControllers\DriverController;
use App\Http\Controllers\ClientControllers\ReviewController;
use Laravel\Socialite\Facades\Socialite;

//Route::get("testLouisa", function () {
//  return "route using louisaroute.php";
//})->name("testLouisa");


Route::get("indexUser", [SharedController::class, "indexUser"])->name("indexUser")->middleware("Unauth");

Route::middleware(['clientMW'])->group(function () {

    //client profile
    Route::get("displayUserProfile/{id}", [ProfileController::class, "displayUserProfile"])->name("displayUserProfile");
    Route::get("UserturnOnEdit/{id}", [ProfileController::class, "UserturnOnEdit"])->name("UserturnOnEdit");
    Route::put("editUserProfile/{id}", [ProfileController::class, "editUserProfile"])->name("editUserProfile");

//browse/rate/review drivers
    Route::get('drivers', [DriverController::class, 'index'])->name('BrowseDrivers');
    Route::get('drivers/{id}', [DriverController::class, 'show'])->name('DriverDetails');
    Route::post('drivers/{driverId}/review', [ReviewController::class, 'store'])->name('DriverReview');

});
// registration
Route::get('auth/client-register', [RegisterController::class, 'showClientRegistrationForm'])->name('clientRegister');
Route::post('auth/client-register', [RegisterController::class, 'registerClient']);
Route::get('auth/driver-register', [RegisterController::class, 'showDriverRegistrationForm']);
Route::post('auth/driver-register', [RegisterController::class, 'registerDriverStep1'])->name('driverRegisterStep1');
Route::get('auth/driver-register-step2', [RegisterController::class, 'showDriverRegistrationStep2'])->name('driverRegisterStep2');
Route::post('auth/driver-register-step2', [RegisterController::class, 'registerDriverStep2']);

// Login
Route::get('auth/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('auth/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('googleLogin');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);




//GitHub routes
Route::get('login/github', [GitHubController::class, 'redirectToGitHub'])->name('githubLogin');
Route::get('login/github/callback', [GitHubController::class, 'handleGitHubCallback']);

//otp routes
Route::get('verify-otp', [OtpController::class, 'show'])->name('verifyOtpForm');
Route::post('verify-otp', [OtpController::class, 'verify'])->name('verifyOtp');
Route::post('/resend-otp', [OtpController::class, 'resend'])->name('resendOtp');


