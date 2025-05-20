<?php

namespace App\Http\Controllers\ClientControllers;

use App\Events\SuccessNotificationEvent;
use App\Events\TestPusherEvent;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Request as DeliveryRequest;

use App\Models\User;
use App\Models\Delivery;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Checkout\Session;


class DeliveryCreationController extends Controller
{
    public function DeliveryForm()
    {
        return view("ClientViews.CreateDeliveryView");
    }

    public function ReturnHomePage()
    {
        return view("UserHomeView");
    }



    public function FilterDrivers(Request $request)
    {
        // Validate only the required fields
        $request->validate([
            'deliveryDescription' => 'required|string',
            'weightQuantity' => 'required|numeric|min:0.01',
            'scheduledDeliveryDate' => 'required|date|after_or_equal:now|unique:deliveries,scheduledDeliveryDate',

            'pickedFromX' => 'required|numeric',
            'pickedFromY' => 'required|numeric',
            'destinationX' => 'required|numeric',
            'destinationY' => 'required|numeric',
        ], [
            'deliveryDescription.required' => 'Description is required.',
            'weightQuantity.required' => 'Weight is required.',
            'weightQuantity.numeric' => 'Weight must be a number.',
            'weightQuantity.min' => 'Weight must be greater than 0.',
            'scheduledDeliveryDate.required' => 'Scheduled delivery date is required.',
            'scheduledDeliveryDate.after_or_equal' => 'Scheduled delivery date cannot be in the past.',
            'scheduledDeliveryDate.unique' => 'A delivery date has already been scheduled. Please choose a different time.',
            'pickedFromX.required' => 'Pickup location is required.',
            'pickedFromY.required' => 'Pickup location is required.',
            'destinationX.required' => 'Destination location is required.',
            'destinationY.required' => 'Destination location is required.',
        ]);

        // Get all the data after validation
        $data = $request->all();

        // Continue as usual
        $distance = $this->calculateDistance(
            $data['pickedFromX'], $data['pickedFromY'],
            $data['destinationX'], $data['destinationY']
        );
        $data['distanceInKm'] = $distance;

        $drivers = $this->filterDriversByCitiesAndTime($data);
        $data['availableDrivers'] = $drivers;

        return view("ClientViews.ChooseDriverView")->with("data", $data);

      //  return response()->json($data);
    }



    public function searchDrivers(Request $request)
    {
        $data = $request->all();

        $distance = $this->calculateDistance(
            $data['pickedFromX'], $data['pickedFromY'],
            $data['destinationX'], $data['destinationY']
        );
        $data['distanceInKm'] = $distance;


        $drivers = $this->filterDriversByCitiesAndTime($data);


        if ($request->filled('search')) {
            $searchTerm = strtolower($request->input('search'));

            $drivers = $drivers->filter(function ($driver) use ($searchTerm) {
                return str_contains(strtolower($driver->userName), $searchTerm);
            })->values();
        }

        $data['availableDrivers'] = $drivers;

        return view("ClientViews.ChooseDriverView")->with("data", $data);
    }




    private function filterDriversByCitiesAndTime($data)
    {
        $time = \Carbon\Carbon::parse($data['scheduledDeliveryDate'])->format('H:i:s');

        $pickupCityName = $data['pickupCity'];
        $destinationCityName = $data['destinationCity'];



        $availableDrivers = User::where('role_id', 2)
            ->whereTime('startShift', '<=', $time)
            ->whereTime('endShift', '>=', $time)
         ->where('gotRegistered', 'accepted')
            ->whereHas('cities', function ($query) use ($pickupCityName) {
                $query->where('cityName', $pickupCityName);
            })
            ->whereHas('cities', function ($query) use ($destinationCityName) {
                $query->where('cityName', $destinationCityName);
            })
            ->with('cities')
            ->get();


        return $availableDrivers;
    }


    public function PaymentPage(Request $request)
    {
        $driverId = $request->input('driver_id');
        $driver = User::with('priceStructure')->findOrFail($driverId);


        if ($request->has('deliveryData') && is_string($request->input('deliveryData'))) {
            $deliveryData = json_decode($request->input('deliveryData'), true);
        } elseif ($request->has('deliveryData') && is_array($request->input('deliveryData'))) {

            $deliveryData = $request->input('deliveryData');
        } else {

            $deliveryData = $request->except('driver_id');
        }

        // Safely check required fields
        if (!isset($deliveryData['weightQuantity']) || !isset($deliveryData['distanceInKm'])) {
            return response()->json(['error' => 'Missing delivery data'], 400);
        }

        $weight = $deliveryData['weightQuantity'];
        $distance = $deliveryData['distanceInKm'];

        $priceStructure = $driver->priceStructure;

        $totalWeightPrice = ($priceStructure->weightPrice * $weight) / $priceStructure->weightQuantity;

        if ($priceStructure->fixedDistancePrice !== null) {
            $totalDistancePrice = $priceStructure->fixedDistancePrice;
        } elseif ($priceStructure->distancePerKm && $priceStructure->distancePrice) {
            $totalDistancePrice = ($distance / $priceStructure->distancePerKm) * $priceStructure->distancePrice;
        } else {
            $totalDistancePrice = 0;
        }

        $totalDeliveryPrice = $totalWeightPrice + $totalDistancePrice;

        return view('ClientViews.DeliveryPaymentView', [
            'deliveryData' => $deliveryData,
            'driverId' => $driverId,
            'totalWeightPrice' => $totalWeightPrice,
            'totalDistancePrice' => $totalDistancePrice,
            'totalDeliveryPrice' => $totalDeliveryPrice
        ]);
    }






    public function createSession(Request $request)
    {
      #  Stripe::setApiKey(' '); // your secret key

        $totalWeightPrice = $request->input('totalWeightPrice');
        $totalDistancePrice = $request->input('totalDistancePrice');
        $totalDeliveryPrice = $request->input('totalDeliveryPrice');
        $driverId = $request->input('driverId');
        $deliveryData = $request->input('deliveryData');
        $paymentMethod  = $request->input('paymentMethod');
        $discount = $request->input('discount');


        $successUrl = url('/SuccessfulPayment') . '?' . http_build_query([
                'driverId' => $driverId,
                'totalPrice' => $totalDeliveryPrice,
                'deliveryData' => json_encode($deliveryData),  // ✅
                'totalWeightPrice' => $totalWeightPrice,
                'totalDistancePrice' => $totalDistancePrice,
                'paymentMethod' => $paymentMethod,
                'discount'=>$discount
            ]);

        $cancelUrl = url('/PaymentPage') . '?' . http_build_query([
                'driver_id' => $driverId,
                'deliveryData' => $deliveryData // ✅
            ]);




        $unitAmountInCents = (int)($totalDeliveryPrice * 100);

        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Delivery Bill price : ',
                    ],
                    'unit_amount' => $unitAmountInCents,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);

        return response()->json(['id' => $session->id]);
    }



    public function createCoinbaseSession(Request $request)
    {
        $apiKey = '035d5c2a-e4e0-4587-acaf-488ca837d284';

        $price = number_format($request->totalDeliveryPrice, 2, '.', '');
        $response = Http::withHeaders([
            'X-CC-Api-Key' => $apiKey,
            'X-CC-Version' => '2018-03-22',
        ])->post('https://api.commerce.coinbase.com/charges', [
            'name' => 'Delivery Payment',
            'description' => 'Payment for delivery service',
            'pricing_type' => 'fixed_price',
            'local_price' => [
                'amount' => $price,
                'currency' => 'USD'
            ],
            'metadata' => [
                'driver_id' => $request->driverId,
                'delivery_data' => json_encode($request->deliveryData)
            ],
            'redirect_url' => route('Success'), // or a success page
            'cancel_url' => url()->previous()
        ]);

        if ($response->successful()) {
            return response()->json([
                'hosted_url' => $response['data']['hosted_url']
            ]);
        } else {
            return response()->json(['error' => 'Unable to create session'], 500);
        }
    }




    public  function test1(Request $request)
    {
        return response()->json([$request->all()]);
    }


    public function Success(Request $request)
    {
        $deliveryData = json_decode($request->query('deliveryData'), true);

        $deliveryDescription   = $deliveryData['deliveryDescription'] ?? null;
        $weightQuantity        = $deliveryData['weightQuantity'] ?? null;
        $scheduledDeliveryDate = $deliveryData['scheduledDeliveryDate'] ?? null;
        $pickedFromX           = $deliveryData['pickedFromX'] ?? null;
        $pickedFromY           = $deliveryData['pickedFromY'] ?? null;
        $destinationX          = $deliveryData['destinationX'] ?? null;
        $destinationY          = $deliveryData['destinationY'] ?? null;
       $discount =  $request->input('discount');


        $user = Auth::user();

        if ($discount == 15) {
            $user->points -= 150;
            $user->save();
        } elseif ($discount == 20) {
            $user->points -= 250;
            $user->save();
        } elseif ($discount == 30) {
            $user->points -= 400;
            $user->save();
        }




        $delivery = Delivery::create([
            'deliveryDescription'   => $deliveryDescription,
            'weightQuantity'        => $weightQuantity,
            'totalWeightPrice'      => $request->query('totalWeightPrice'),
            'totalDistancePrice'    => $request->query('totalDistancePrice'),
            'totalDeliveryPrice'    => $request->query('totalPrice'),
            'pickedFromX'           => $pickedFromX,
            'pickedFromY'           => $pickedFromY,
            'destinationX'          => $destinationX,
            'destinationY'          => $destinationY,
            'scheduledDeliveryDate' => $scheduledDeliveryDate,
            'paymentMethod'         => $request->query('paymentMethod'),
            'discount' => $request->input('discount'),

            'deliveredTo'           => Auth::user()->id, // or pass via query/session
            'deliveredBy'           => $request->query('driverId'),

        ]);

        DeliveryRequest::create([
            'delivery_id' => $delivery->id
        ]);


        return view('ClientViews.SuccessPaymentView'); // show a success view
    }


//Just a json Preview to see the data
    public function preview(Request $request)
    {
        $data = $request->all();


        $distance = $this->calculateDistance(
            $data['pickedFromX'], $data['pickedFromY'],
            $data['destinationX'], $data['destinationY']
        );
        $data['distanceInKm'] = $distance;

        return response()->json($data);
    }







// Function to calculate the distance in KM using Haversine formula
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }

}
