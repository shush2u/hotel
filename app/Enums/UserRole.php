<?php

namespace App\Enums;

enum UserRole: string
{
    case REGISTERED_USER = 'registeredUser';
    case ADMINISTRATOR = 'administrator';
}