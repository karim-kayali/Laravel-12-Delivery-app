<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\City;
use App\Models\PriceStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\OtpMail;

class RegisterController extends Controller
{
    public function showClientRegistrationForm()
    {
        return view('auth.ClientRegister');
    }

    public function registerClient(Request $request)
    {
        $validated = $request->validate([
        'userName' => 'required|string|unique:users,userName',
        'email' => 'required|email|unique:users,email',
        'phoneNumber' => 'nullable|string|unique:users,phoneNumber',
        'password' => 'required|string|min:8|confirmed',
        ]);

        $otp = rand(100000, 999999);

        Session::put('client_registration_data', [
            'userName' => $request->userName,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'password' => $request->password,
            'role_id' => Role::where('roleName', 'user')->first()->id,
            'otp' => $otp,
        ]);

        Mail::to($request->email)->send(new OtpMail($otp));

        return redirect()->route('verifyOtp')->with('email', $request->email);
    }

    public function showDriverRegistrationForm()
    {
        return view('auth.DriverRegister');
    }

    public function registerDriverStep1(Request $request)
    {
        $validated = $request->validate([
            'userName' => 'required|string|unique:users,userName',
            'email' => 'required|email|unique:users,email',
            'phoneNumber' => 'required|string|unique:users,phoneNumber',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $otp = rand(100000, 999999);

        Session::put('driver_registration_data', [
            'userName' => $request->userName,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'password' => $request->password,
            'role_id' => Role::where('roleName', 'driver')->first()->id,
            'otp' => $otp,
        ]);

        Mail::to($request->email)->send(new OtpMail($otp));

        return redirect()->route('verifyOtp')->with('email', $request->email);
    }

    public function showDriverRegistrationStep2()
    {
        $cities = City::all();
        return view('auth.DriverRegisterStep2', compact('cities'));
    }


    public function registerDriverStep2(Request $request)
    {
         // Only validate if final submit is true
        if (!$request->has('finalSubmit') || $request->input('finalSubmit') !== '1') {
        // Just return back with the selected pricing model and no errors
        return back()->withInput();
        }



        $validatedData = $request->validate([
        'vehicleType' => 'required|string',
        'vehicleModel' => 'required|string',
        'plateNumber' => 'required|string',
        'startShift' => 'required|date_format:H:i',
        'endShift' => 'required|date_format:H:i',
        'citiesToServe' => 'required|array|min:1',
        'priceModel' => 'required|in:fixed,dynamic',
        'weightQuantity' => 'required|numeric|min:0',
        'weightPrice' => 'required|numeric|min:0',
        'fixedPrice' => 'required_if:priceModel,fixed|numeric|min:0',
        'distance' => 'required_if:priceModel,dynamic|numeric|min:0',
        'pricePerKm' => 'required_if:priceModel,dynamic|numeric|min:0',
        ]);

        $user = auth()->user();


        $user->update([
        'vehicleType' => $request->vehicleType,
        'vehicleModel' => $request->vehicleModel,
        'plateNumber' => $request->plateNumber,
        'startShift' => $request->startShift,
        'endShift' => $request->endShift,
        'gotRegistered' => 'pending',
        ]);

         $user->cities()->sync($request->citiesToServe);

    // Save pricing structure
    $priceStructure = new PriceStructure();
    $priceStructure->user_id = $user->id;
    $priceStructure->weightQuantity = $request->weightQuantity;
    $priceStructure->weightPrice = $request->weightPrice;

       if ($request->priceModel === 'fixed') {
            $priceStructure->fixedDistancePrice = $request->fixedPrice;
        } elseif ($request->priceModel === 'dynamic') {
              $priceStructure->distancePerKm = $request->distance;
               $priceStructure->distancePrice = $request->pricePerKm;
       }

     $priceStructure->save();

    return redirect()->route('deliveries.pending');
   }
}
