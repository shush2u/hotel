<?php

namespace App\Enums;

enum RoomType: string
{
    case SINGLE = 'single';
    case DOUBLE = 'double';
    case TRIPLE = 'triple';
}