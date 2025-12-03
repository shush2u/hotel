<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\RoomType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RoomFactory extends Factory
{

    
    public function definition(): array
    {
        $sourceDir = database_path('seeders/room_photos');
        
        $patterns = ['jpg', 'jpeg', 'png', 'gif'];
        $imageFiles = [];

        foreach ($patterns as $ext) {
            $imageFiles = array_merge($imageFiles, glob("$sourceDir/*.$ext"));
        }

        if (empty($imageFiles)) {
            $photoData = null;
        } else {
            $randomFilePath = fake()->randomElement($imageFiles);
        
            $photoData = file_get_contents($randomFilePath);
        }

        return [
            'roomNumber' => fake()->unique()->numerify('###'),
            'roomType' => fake()->randomElement(RoomType::cases()),
            'costPerNight' => fake()->randomFloat(2, 70, 350),
            'description' => fake()->paragraph(),
            'tv' => fake()->boolean(),
            'wifi' => fake()->boolean(true),
            'photo' => $photoData,
        ];
    }
}