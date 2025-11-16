<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Enums\UserRole; // Import enum

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'fullName' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'profilePicture' => fake()->imageUrl(200, 200, 'people'),
            'role' => UserRole::REGISTERED_USER, // Default to registered user
            'phoneNumber' => fake()->phoneNumber(),
            'isActive' => true,
            'remember_token' => Str::random(10),
        ];
    }
    
    // ... (keep the unverified() state if it exists)
}