<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('roomNumber')->unique();
            $table->string('roomType'); // Corresponds to Room Type enum
            $table->decimal('costPerNight', 8, 2); // 'decimal' is best for currency
            $table->text('description')->nullable();
            $table->boolean('tv')->default(false);
            $table->boolean('wifi')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};