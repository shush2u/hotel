<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomPhotoFactory extends Factory
{
    public function definition(): array
    {
        return [
            // room_id will be provided when calling the factory
            'photo' => fake()->imageUrl(1024, 768, 'hotel room', true),
            'orderPosition' => fake()->numberBetween(1, 5),
        ];
    }
}