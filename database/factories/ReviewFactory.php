<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        // room_booking_id will be provided
        return [
            'rating' => fake()->numberBetween(1, 5),
            'description' => fake()->sentence(),
        ];
    }
}