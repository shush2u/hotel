<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'fromDate',
        'toDate',
    ];

    protected $casts = [
        'fromDate' => 'date',
        'toDate' => 'date',
    ];

    /**
     * Get the user that made the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the room that was booked.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the review associated with the booking.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}