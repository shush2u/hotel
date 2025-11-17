<?php

namespace App\Models;

use App\Enums\RoomType; // Import the Enum
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
        'photo'
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
     * Scope a query to include only rooms available within a specific date range.
     * A room is unavailable if its booking date range overlaps with the requested range.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $fromDate (YYYY-MM-DD)
     * @param string $toDate (YYYY-MM-DD)
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailableInDateRange(Builder $query, string $fromDate, string $toDate): Builder
    {
        return $query->whereDoesntHave('roomBookings', function (Builder $bookingQuery) use ($fromDate, $toDate) {
            $bookingQuery->where(function ($q) use ($fromDate, $toDate) {
                $q->where('check_in_date', '<', $toDate); 
                $q->where('check_out_date', '>', $fromDate);
            });
        });
    }
}