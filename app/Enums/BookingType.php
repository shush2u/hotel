<?php

namespace App\Enums;

enum BookingType: string
{
    case CLIENT = 'client';
    case MAINTENANCE = 'maintenance';
    case OTHER = 'other';
}