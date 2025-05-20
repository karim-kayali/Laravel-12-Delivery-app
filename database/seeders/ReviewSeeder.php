<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $review = new Review();
        $review->ReviewDescription = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s";
        $review->rating = 3;
        $review->client_id = 1;
        $review->driver_id = 4;
        $review->save();

        $review = new Review();
        $review->ReviewDescription = "Testing Description 2";
        $review->rating = 2;
        $review->client_id = 2;
        $review->driver_id = 4;
        $review->save();

        $review = new Review();
        $review->ReviewDescription = "Testing Description 3";
        $review->rating = 4;
        $review->client_id = 1;
        $review->driver_id = 5;
        $review->save();

        $review = new Review();
        $review->ReviewDescription = "Testing Description 4";
        $review->rating = 4;
        $review->client_id = 2;
        $review->driver_id = 5;
        $review->save();
    }
}
