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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->longText("ReviewDescription");
            //Rating should be between 0 and 5 INCLUSIVE
            $table->tinyInteger('rating');
            $table->foreignId("client_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreignId("driver_id")->references("id")->on("users")->onDelete("cascade");
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
