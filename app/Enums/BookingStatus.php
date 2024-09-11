<?php declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumUtils;

enum BookingStatus: int
{
    use EnumUtils;

    case PENDING = 0;           // Booking is initiated but not yet confirmed
    case CONFIRMED = 1;         // Booking is confirmed and secured
    case PAYMENT_FAILED = 2;    // Payment for the booking failed
    case CANCELED = 3;          // Booking was canceled
    case CHECKED_IN = 4;        // Guest has checked in
    case CHECKED_OUT = 5;       // Guest has checked out
    case NO_SHOW = 6;           // Guest did not show up for the booking
    case UNDER_REVIEW = 7;      // Booking is under review or awaiting approval
    case COMPLETED = 8;         // Booking process is fully completed
}
