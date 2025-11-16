<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // unique() enforces the 0..1 relationship
            $table->foreignId('room_booking_id')->unique()->constrained('room_bookings')->onDelete('cascade');
            $table->unsignedTinyInteger('rating'); // Good for 1-5 scale
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};