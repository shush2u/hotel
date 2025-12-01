<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\NotificationType;

class NotificationFactory extends Factory
{
    protected static ?string $password;

    protected static ?array $roleDistribution = null;

    protected static function getRoleDistribution(): array
    {
        if (self::$roleDistribution === null) {
            self::$roleDistribution = array_merge(
                array_fill(0, 20, NotificationType::INFO),
                array_fill(0, 80, NotificationType::IMPORTANT),
            );
        }

        return self::$roleDistribution;
    }

    public function definition(): array
    {
        return [
            'notification_type' => fake()->randomElement(self::getRoleDistribution()),
            'message' => fake()->text(),
            'acknowledged' => fake()->boolean(20),
        ];
    }
}