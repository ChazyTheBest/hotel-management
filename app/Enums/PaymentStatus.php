<?php declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumUtils;

enum PaymentStatus: int
{
    use EnumUtils;

    case PENDING = 0;       // Payment is initiated but not yet processed
    case PROCESSING = 1;    // Payment is currently being processed
    case SUCCESS = 2;       // Payment has been successfully completed
    case FAILED = 3;        // Payment failed to complete
    case CANCELLED = 4;     // Payment was cancelled by the user or system
    case REFUNDED = 5;      // Payment was completed but later refunded
    case DISPUTED = 6;      // Payment is under dispute or being investigated
}
