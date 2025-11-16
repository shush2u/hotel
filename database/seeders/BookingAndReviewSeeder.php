<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\Review;
use App\Enums\UserRole;

class BookingAndReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Get registered users and all rooms
        $users = User::where('role', UserRole::REGISTERED_USER)->get();
        $rooms = Room::all();

        // Ensure we have enough users
        if ($users->count() < 3) {
            $this->command->warn('Not enough registered users to seed all booking scenarios. Need 3.');
            return;
        }

        // --- Scenario 1: 1 user with 1 booking in the future ---
        RoomBooking::factory()->create([
            'user_id' => $users[0]->id,
            'room_id' => $rooms->random()->id,
            'fromDate' => now()->addMonth(),
            'toDate' => now()->addMonth()->addDays(3),
        ]);

        // --- Scenario 2: 1 user with 1 booking in the past (no review) ---
        RoomBooking::factory()->create([
            'user_id' => $users[1]->id,
            'room_id' => $rooms->random()->id,
            'fromDate' => now()->subMonths(2),
            'toDate' => now()->subMonths(2)->addDays(5),
        ]);

        // --- Scenario 3: 1 user with 2 bookings in the past, both with a review ---
        $user3 = $users[2];

        // Booking 3.1
        $booking1 = RoomBooking::factory()->create([
            'user_id' => $user3->id,
            'room_id' => $rooms->random()->id,
            'fromDate' => now()->subYear(),
            'toDate' => now()->subYear()->addDays(4),
        ]);
        // Review for Booking 3.1
        Review::factory()->create(['room_booking_id' => $booking1->id]);

        // Booking 3.2
        $booking2 = RoomBooking::factory()->create([
            'user_id' => $user3->id,
            'room_id' => $rooms->random()->id,
            'fromDate' => now()->subMonths(6),
            'toDate' => now()->subMonths(6)->addDays(2),
        ]);
        // Review for Booking 3.2
        Review::factory()->create(['room_booking_id' => $booking2->id]);
    }
}