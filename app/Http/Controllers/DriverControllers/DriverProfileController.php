<?php

namespace App\Http\Controllers\DriverControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PriceStructure;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Log;

class DriverProfileController extends Controller
{
    /**
     * Display the driver's profile in view mode.
     */
    public function displayDriverProfile($id) {
        $onEdit = false;
        $user = User::find($id);

        // Check if the user matches the authenticated user
        if ($user->id == Auth::user()->id) {
            // Fetch the price structure, cities, and user city IDs
            $priceStructure = PriceStructure::where('user_id', $id)->first();
            $cities = City::all();
            $userCityIds = $user->cities()->pluck('cities.id')->toArray();

            // Return the profile view with the relevant data
            return view('DriverViews.DriverProfile', compact('user', 'onEdit', 'priceStructure', 'cities', 'userCityIds'));
        } else {
            return abort(403);
        }
    }

    public function DriverTurnOnEdit($id) {
        $onEdit = true;
        $user = User::findOrFail($id);

        // Check if the user matches the authenticated user
        if ($user->id == Auth::user()->id) {
            // Fetch the price structure, cities, and user city IDs
            $priceStructure = PriceStructure::where('user_id', $id)->first();
            $cities = City::all();
            $userCityIds = $user->cities()->pluck('cities.id')->toArray();

            // Return the profile view with the relevant data and the onEdit flag set to true
            return view('DriverViews.DriverProfile', compact('user', 'onEdit', 'priceStructure', 'cities', 'userCityIds'));
        } else {
            return abort(403);
        }
    }



    /**
     * Save the updated driver profile.
     */
    public function editDriverProfile(Request $request, $id)
    {
        $validatedData = $request->validate([

            'userName' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'userName')->ignore($id),
            ],
            'phoneNumber' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'phoneNumber')->ignore($id),
                ],

            'vehicleType'        => 'required','string',
        'vehicleModel'       => 'required','string', 'max:20', 'regex:/^[A-Za-z\s]+$/',
        'plateNumber'        => 'required','string', 'regex:/^[A-Z0-9-]+$/', 'min:7', 'max:10',
        'startShift'         => 'required',
        'endShift'           => 'required',
        'weightQuantity'     => 'required', 'numeric', 'min:1',
        'weightPrice'        => 'required', 'numeric', 'min:1',
        'pricing_model'      => 'required', 'string',
        'fixedDistancePrice' => 'nullable', 'required_if:pricing_model,Fixed Rate', 'numeric',
        'distancePerKm'      => 'nullable', 'required_if:pricing_model,Rate per KM', 'numeric',
        'distancePrice'      => 'nullable', 'required_if:pricing_model,Rate per KM', 'numeric',
    ]);
        $user = User::findOrFail($id);

        if($user->id == Auth::id()) {


            $user->update($validatedData);

// If the username is updated, it will be validated and saved automatically here
    //            if ($request->has('username')) {
    //                $user->username = $request->input('username');
    //                $user->save();
    //            }

            $this->updatePricing($request, $user);
            $this->updateShifts($request, $user);

            // Sync selected cities
            $user->cities()->sync($request->input('cities', []));
            $user->save();
            return redirect()
                ->route('displayDriverProfile', ['id' => $user->id])
                ->with('success', 'Profile updated successfully!');
        } else {
            return abort(403);
        }


    }

    /**
     * Update the pricing information for the driver.
     */

    private function updatePricing(Request $request, $user)
    {
        Log::debug('Updating Pricing Data for User ID:', [$user->id]);

        if($user->id == Auth::id()) {
            if ($request->pricing_model === 'fixed') {
                if (empty($request->fixedDistancePrice) || $request->fixedDistancePrice <= 0) {
                    throw ValidationException::withMessages([
                        'fixedDistancePrice' => 'The Fixed Distance Price must be greater than 0 when using the Fixed pricing model.',
                    ]);
                }
            } elseif ($request->pricing_model === 'per_km') {
                if (
                    empty($request->distancePerKm) || $request->distancePerKm <= 0 ||
                    empty($request->distancePrice) || $request->distancePrice <= 0
                ) {
                    throw ValidationException::withMessages([
                        'distancePerKm' => 'Distance per KM must be greater than 0 when using the Rate per KM pricing model.',
                        'distancePrice' => 'Distance price must be greater than 0 when using the Rate per KM pricing model.',
                    ]);
                }
            }

            $priceStructure = $user->priceStructure ?? new PriceStructure(['user_id' => $user->id]);

            if ($request->has('weightQuantity')) {
                $priceStructure->weightQuantity = $request->weightQuantity;
            }

            if ($request->has('weightPrice')) {
                $priceStructure->weightPrice = $request->weightPrice;
            }

            if ($request->pricing_model === 'fixed') {
                $priceStructure->fixedDistancePrice = $request->fixedDistancePrice;
                $priceStructure->distancePerKm = null;
                $priceStructure->distancePrice = null;
            } else {
                $priceStructure->fixedDistancePrice = null;
                $priceStructure->distancePerKm = $request->distancePerKm;
                $priceStructure->distancePrice = $request->distancePrice;
            }

            $priceStructure->save();
        } else {
            return abort(403);
        }

        Log::info('PriceStructure updated successfully for User ID:', [$user->id]);
    }

    /**
     * Update the shift information for the driver.
     */
    private function updateShifts(Request $request, $user)
    {
        Log::debug('Updating Shift Data for User ID:', [$user->id]);

        $request->validate([
            'startShift' => 'nullable',
            'endShift' => 'nullable',
        ]);

        $shiftUpdated = false;

        if ($request->has('startShift')) {
            $user->startShift = $request->startShift;
            $shiftUpdated = true;
            Log::info('Start shift updated for User ID:', [$user->id]);
        }

        if ($request->has('endShift')) {
            $user->endShift = $request->endShift;
            $shiftUpdated = true;
            Log::info('End shift updated for User ID:', [$user->id]);
        }

        if ($shiftUpdated) {
            $user->save();
            Log::info('User shifts updated successfully for User ID:', [$user->id]);
        } else {
            Log::info('No shift update necessary for User ID:', [$user->id]);
        }
    }
}
