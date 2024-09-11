<?php declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumUtils;

enum Role: int
{
    use EnumUtils;

    case GUEST = 0;           // Not logged in, limited or no access
    case USER = 1;            // Regular user with basic access
    case RECEPTIONIST = 2;    // Handles guest services, check-ins and check-outs
    case HOUSEKEEPING = 3;    // Maintains cleanliness and guest room upkeep
    case MAINTENANCE = 4;     // Responsible for repairs and maintenance of facilities
    case CONCIERGE = 5;       // Assists guests with activities, bookings, etc.
    case CHEF = 6;            // Manages kitchen operations and food services
    case SECURITY = 7;        // Ensures safety and security of guests and staff
    case STAFF = 8;           // General staff access to hotel operations
    case MANAGER = 9;         // Manages staff and hotel operations
    case ADMIN = 10;          // Full system administrator with maximum access
}
