<?php

namespace App\Models;

use App\Enums\RoomType; // Import the Enum
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'roomNumber',
        'roomType',
        'costPerNight',
        'description',
        'tv',
        'wifi',
    ];

    protected $casts = [
        'roomType' => RoomType::class, // Cast to Enum
        'costPerNight' => 'decimal:2',
        'tv' => 'boolean',
        'wifi' => 'boolean',
    ];

    /**
     * Get the bookings for the room.
     */
    public function roomBookings()
    {
        return $this->hasMany(RoomBooking::class);
    }

    /**
     * Get the photos for the room.
     */
    public function roomPhotos()
    {
        return $this->hasMany(RoomPhoto::class);
    }
}