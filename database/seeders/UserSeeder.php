<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the Administrator
        User::factory()->create([
            'fullName' => 'Admin User',
            'email' => 'admin@hotel.com',
            'password' => Hash::make('password'), // Simple password for testing
            'role' => UserRole::ADMINISTRATOR,
        ]);

        // 1. Create the Administrator
        User::factory()->create([
            'fullName' => 'Director User',
            'email' => 'director@hotel.com',
            'password' => Hash::make('password'), // Simple password for testing
            'role' => UserRole::DIRECTOR,
        ]);

        // 2. Create 4 Registered Users
        User::factory()->count(4)->create([
            'role' => UserRole::REGISTERED_USER,
        ]);

        $userIds = User::pluck('id');

        $userIds->each(function (int $userId) {
            $notificationCount = rand(1, 3); 
            
            Notification::factory()
                ->count($notificationCount)
                ->create([
                    'user_id' => $userId, 
                ]);
        });
    }
}