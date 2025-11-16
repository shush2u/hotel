<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_booking_id',
        'rating',
        'description',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the booking that the review belongs to.
     */
    public function roomBooking()
    {
        return $this->belongsTo(RoomBooking::class);
    }
}