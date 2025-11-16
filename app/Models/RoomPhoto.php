<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'photo',
        'orderPosition',
    ];

    protected $casts = [
        'orderPosition' => 'integer',
    ];

    /**
     * Get the room that owns the photo.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}