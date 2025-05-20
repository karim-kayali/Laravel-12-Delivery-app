<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\UserCity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $city1 = new City();
        $city1->cityName = "Achrafieh";
        $city1->save();

        $city2 = new City();
        $city2->cityName = "Beirut";
        $city2->save();

        $city3 = new City();
        $city3->cityName = "Baabda";
        $city3->save();

        $city4 = new City();
        $city4->cityName = "Kfarshima";
        $city4->save();

        $city5 = new City();
        $city5->cityName = "Beshamoun";
        $city5->save();

        $city6 = new City();
        $city6->cityName = "Khalde";
        $city6->save();

        $userCity1 = new UserCity();
        $userCity1->user_id = 3;
        $userCity1->city_id = 1;
        $userCity1->save();

        $userCity2 = new UserCity();
        $userCity2->user_id = 3;
        $userCity2->city_id = 2;
        $userCity2->save();

        $userCity3 = new UserCity();
        $userCity3->user_id = 3;
        $userCity3->city_id = 3;
        $userCity3->save();

        $userCity4 = new UserCity();
        $userCity4->user_id = 3;
        $userCity4->city_id = 4;
        $userCity4->save();

        $userCity5 = new UserCity();
        $userCity5->user_id = 4;
        $userCity5->city_id = 4;
        $userCity5->save();

        $userCity6 = new UserCity();
        $userCity6->user_id = 4;
        $userCity6->city_id = 5;
        $userCity6->save();

        $userCity7 = new UserCity();
        $userCity7->user_id = 4;
        $userCity7->city_id = 6;
        $userCity7->save();



    }
}
