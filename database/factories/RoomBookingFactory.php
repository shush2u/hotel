<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomBookingFactory extends Factory
{
    public function definition(): array
    {
        // user_id and room_id will be provided
        $fromDate = fake()->dateTimeBetween('now', '+2 months');
        $toDate = (clone $fromDate)->modify('+' . rand(2, 7) . ' days');

        return [
            'fromDate' => $fromDate,
            'toDate' => $toDate,
        ];
    }
}