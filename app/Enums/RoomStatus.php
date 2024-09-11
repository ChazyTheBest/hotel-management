<?php declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumUtils;

enum RoomStatus: int
{
    use EnumUtils;

    case AVAILABLE = 0;        // Room is available for booking
    case OCCUPIED = 1;         // Room is currently occupied by a guest
    case CLEANING = 2;         // Room is being cleaned and not available for booking
    case MAINTENANCE = 3;      // Room is under maintenance and not available for booking
    case OUT_OF_SERVICE = 4;   // Room is out of service and not available for an extended period
}
