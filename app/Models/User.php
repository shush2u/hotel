<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'fullName',
        'email',
        'password',
        'profilePicture',
        'role',
        'registrationDate',
        'phoneNumber',
        'isActive',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRole::class, // Cast to Enum
        'registrationDate' => 'date',
        'isActive' => 'boolean',
    ];

    /**
     * Get the room bookings for the user.
     */
    public function roomBookings()
    {
        return $this->hasMany(RoomBooking::class);
    }
}