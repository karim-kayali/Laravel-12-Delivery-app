<?php

namespace Database\Seeders;

use App\Models\PriceStructure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //For Rami
        $pricestructure1 = new PriceStructure();
        $pricestructure1->weightQuantity = 30;
        $pricestructure1->weightPrice = 10;
        $pricestructure1->fixedDistancePrice = 8;
        $pricestructure1->user_id = 3;
        $pricestructure1->save();

        //For Louisa
        $pricestructure2 = new PriceStructure();
        $pricestructure2->weightQuantity = 50;
        $pricestructure2->weightPrice = 15;
        $pricestructure2->distancePerKm = 10;
        $pricestructure2->distancePrice = 5;
        $pricestructure2->user_id = 4;
        $pricestructure2->save();

    }
}
