<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('price_structures', function (Blueprint $table) {
            $table->id();
            $table->integer("weightQuantity");
            $table->float("weightPrice");

            //Either this:
            $table->float("fixedDistancePrice")->nullable(); //fixed price for all distances (we do not look at the distance)
            //Or that:
            //specify for each distance (km) how much the price will be
            $table->float("distancePerKm")->nullable();
            $table->float("distancePrice")->nullable();

            $table->foreignId("user_id")->references("id")->on("users")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_structures');
    }
};
