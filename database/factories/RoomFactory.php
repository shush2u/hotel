<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\RoomType; // Import enum
use App\Models\Room;
use App\Models\RoomPhoto;

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
            'wifi' => fake()->boolean(true), // Most rooms have wifi
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Room $room) {
            // Create 1 to 5 photos for this room
            RoomPhoto::factory()
                ->count(rand(1, 5))
                ->create(['room_id' => $room->id]);
        });
    }
}