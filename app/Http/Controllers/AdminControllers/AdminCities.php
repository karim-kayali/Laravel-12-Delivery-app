<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class AdminCities extends Controller
{
    public function AdminCitiesView() {
        $cities = City::all();

        return view('AdminViews/AdminCitiesView', compact('cities'));
    }

    public function AdminCreateCityView() {
        return view('AdminViews/AdminCreateCityView');
    }

    public function AdminCreateCity(Request $request) {
        $request->validate([
            'cityName' => 'required|string|max:255|unique:cities,cityName',
        ]);

        // Create the city
        $city = new City();
        $city->cityName = $request->cityName;
        $city->save();

        return redirect()->route('AdminCitiesView');
    }

    public function AdminEditCityView($id) {
        $city = City::findOrFail($id);

        return view('AdminViews/AdminEditCityView', compact('city'));
    }
    public function AdminEditCity(Request $request, $id) {
        $request->validate([
            'cityName' => 'required|string|max:255|unique:cities,cityName'
        ]);

        $city = City::findOrFail($id);
        $city->cityName = $request->cityName;
        $city->save();
        return redirect()->route('AdminCitiesView');
    }

    public function AdminDeleteCity($id) {
        $city = City::findOrFail($id);
        $city->delete();

        return redirect()->route('AdminCitiesView');
    }


}
