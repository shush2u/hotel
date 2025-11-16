<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Enums\RoomType;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create one of each required room type
        Room::factory()->create(['roomType' => RoomType::SINGLE]);
        Room::factory()->create(['roomType' => RoomType::DOUBLE]);
        Room::factory()->create(['roomType' => RoomType::TRIPLE]);

        // 2. Create 5 more rooms with random types
        // The RoomFactory's 'afterCreating' hook will add photos
        Room::factory()->count(5)->create();
    }
}