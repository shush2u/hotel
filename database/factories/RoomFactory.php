<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\RoomType;

class RoomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'roomNumber' => fake()->unique()->numerify('###'),
            'roomType' => fake()->randomElement(RoomType::cases()),
            'costPerNight' => fake()->randomFloat(2, 70, 350),
            'description' => fake()->paragraph(),
            'tv' => fake()->boolean(),
            'wifi' => fake()->boolean(true),
            'photo' => 'https://placehold.co/600x400/orange/white?text=placeholder',
        ];
    }
}