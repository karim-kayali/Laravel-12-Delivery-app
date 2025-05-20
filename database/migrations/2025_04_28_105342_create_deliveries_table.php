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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->longText("deliveryDescription");
            $table->integer("weightQuantity");
            $table->float("totalWeightPrice");
            $table->float("totalDistancePrice"); //it will either have fixed delivery price or regle de 3 (second option)
            $table->float("totalDeliveryPrice");
            //Xs and Ys will be retrieved potentially from Google Maps API
            $table->double("pickedFromX");
            $table->double("pickedFromY");
            $table->double("destinationX");
            $table->double("destinationY");
            //dateTime stores the year, Month, Day and also time: Hour, minute, seconds in one data cell
            $table->dateTime("scheduledDeliveryDate");

            $table->string("paymentMethod");

            $table->enum('discount', [15, 20, 30])->nullable();
            $table->foreignId("deliveredTo")->references("id")->on("users")->onDelete("cascade");
            $table->foreignId("deliveredBy")->references("id")->on("users")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
