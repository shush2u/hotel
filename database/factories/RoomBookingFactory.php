<?php

namespace Database\Factories;

use App\Enums\BookingType;
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
            'booking_type' => BookingType::CLIENT
        ];
    }
}