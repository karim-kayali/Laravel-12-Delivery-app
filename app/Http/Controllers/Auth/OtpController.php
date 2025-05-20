<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class OtpController extends Controller
{
    public function show(Request $request)
    {
        return view('auth.verifyOtp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|digits:6',
            
        ]);

        // Check if user is not yet registered in DB
        $sessionKey = Session::has('client_registration_data') ? 'client_registration_data' : 'driver_registration_data';
        $data = Session::get($sessionKey);

        if (!$data || $data['email'] !== $request->email || $data['otp'] != $request->otp_code) {
            return back()->with('error', 'Invalid or expired OTP. Please try again.');
        }

        // Create user after OTP verified
        $user = User::create([
            'userName' => $data['userName'],
            'email' => $data['email'],
            'phoneNumber' => $data['phoneNumber'],
            'password' => bcrypt($data['password']),
            'role_id' => $data['role_id'],
            'email_verified_at' => now(),
        ]);

        Auth::login($user);
        Session::forget($sessionKey);

        if ($user->role_id == Role::where('roleName', 'user')->first()->id) {
            return redirect()->route('indexUser');
        } elseif ($user->role_id == Role::where('roleName', 'driver')->first()->id) {
            return redirect()->route('driverRegisterStep2'); // Continue registration
        }

        return redirect('/');
    }
    public function resend(Request $request)
{
   

    // Check if user data is in session
    if (Session::has('client_registration_data') || Session::has('driver_registration_data')) {
        $sessionKey = Session::has('client_registration_data') ? 'client_registration_data' : 'driver_registration_data';
        $data = Session::get($sessionKey);

        // Ensure the email matches the one in session
        if ($data['email'] !== $request->email) {
            return back()->with('error', 'Email does not match the registration data.');
        }

        // Generate new OTP and update session
        $otp = rand(100000, 999999);
        $data['otp'] = $otp;
        Session::put($sessionKey, $data);

        // Send new OTP
        Mail::to($request->email)->send(new OtpMail($otp));

        return back()->with('success', 'A new OTP has been sent to your email.');
    }

    return back()->with('error', 'No registration session found. Please register again.');
}
}
