<?php
/*
namespace App\Http\Controllers\DriverControllers;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PriceStructure;
use App\Models\User;
use Log;

class DefinePricingController extends Controller
{
    // Show the driver update form
    public function showUpdateForm()
    {
        $user = auth()->user();

        if ($user->role_id !== 2 ) {
            abort(403, 'Unauthorized.');
        }

        if ($user->gotRegistered === 'pending') {
            return view('DriverViews.WaitingConfirmation');
        }

        if ($user->gotRegistered === 'rejected') {
            return view('DriverViews.Rejected');
        }

         Check if the form was already shown using cache
        $cacheKey = 'form_shown_user_' . $user->id;

        if (Cache::has($cacheKey)) {
            return redirect()->route('indexDriver'); // Redirect to indexDriver
        }

        // Mark as shown
        Cache::forever($cacheKey, true);

        // Show the form
        $priceStructure = PriceStructure::where('user_id', $user->id)->first();
        return view('DriverViews.UpdateDriverForm', compact('user', 'priceStructure'));
    }


    // Update both pricing and shift information
    public function updateDriverInfo(Request $request)
    {
        // Log the incoming request data for debugging
        Log::debug('Incoming Request Data:', $request->all());

        // Get the authenticated user (no need to pass ID from the route)
        $user = auth()->user();

        // Update pricing and shifts
        $this->updatePricing($request, $user);
        $this->updateShifts($request, $user);

        // Success message
        $successMessage = 'Driver info has been updated!';

        // Redirect after updating, with the success message
        return redirect()->route('driver.update.form')
            ->with('success', $successMessage);
    }

    // Update the pricing information for the driver
    public function updatePricing(Request $request, $user)
    {
        // Log the request data to see what is being passed
        Log::debug('Updating Pricing Data for User ID:', [$user->id]);

        $request->validate([
            'startShift' => 'required',
            'endShift' => 'required',
            'weightQuantity' => 'required|numeric',
            'weightPrice' => 'required|numeric',
            'pricing_model' => 'required|string',
            'fixedDistancePrice' => 'nullable|numeric',
            'distancePerKm' => 'nullable|numeric',
            'distancePrice' => 'nullable|numeric',
        ]);

        // Check if a PriceStructure exists for the user
        $priceStructure = $user->priceStructure ?? new PriceStructure(['user_id' => $user->id]);

        // Handle the pricing fields
        if ($request->has('weightQuantity')) {
            $priceStructure->weightQuantity = $request->weightQuantity;
        }
        if ($request->has('weightPrice')) {
            $priceStructure->weightPrice = $request->weightPrice;
        }

        if ($request->pricing_model === 'fixed') {
            if ($request->has('fixedDistancePrice')) {
                $priceStructure->fixedDistancePrice = $request->fixedDistancePrice;
            }
            // Nullify the distance-based pricing for fixed model
            $priceStructure->distancePerKm = null;
            $priceStructure->distancePrice = null;
        } else {
            // Nullify fixed pricing for per-km model
            $priceStructure->fixedDistancePrice = null;
            if ($request->has('distancePerKm')) {
                $priceStructure->distancePerKm = $request->distancePerKm;
            }
            if ($request->has('distancePrice')) {
                $priceStructure->distancePrice = $request->distancePrice;
            }
        }

        // Save PriceStructure
        $priceStructure->save();

        Log::info('PriceStructure updated successfully for User ID:', [$user->id]);
    }

    // Update shift information for the driver
    private function updateShifts(Request $request, $user)
    {
        Log::debug('Updating Shift Data for User ID:', [$user->id]);

        // Validate the shift-related fields (both are optional)
        $request->validate([
            'startShift' => 'nullable',
            'endShift' => 'nullable',
        ]);

        // Flag to determine if any shift was updated
        $shiftUpdated = false;

        // Update the startShift only if it's provided
        if ($request->has('startShift')) {
            // If provided, update the startShift field
            $user->startShift = $request->startShift;
            $shiftUpdated = true;
            Log::info('Start shift updated for User ID:', [$user->id]);
        }

        // Update the endShift only if it's provided
        if ($request->has('endShift')) {
            // If provided, update the endShift field
            $user->endShift = $request->endShift;
            $shiftUpdated = true;
            Log::info('End shift updated for User ID:', [$user->id]);
        }

        // Save the user only if any shift was updated
        if ($shiftUpdated) {
            $user->save();
            Log::info('User shifts updated successfully for User ID:', [$user->id]);
        } else {
            Log::info('No shift update necessary for User ID:', [$user->id]);
        }
    }
}
*/
