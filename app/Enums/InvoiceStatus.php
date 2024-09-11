<?php declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumUtils;

enum InvoiceStatus: int
{
    use EnumUtils;

    case DRAFT = 0;     // Invoice is created but not yet finalized or sent
    case ISSUED = 1;    // Invoice has been issued to the guest, awaiting payment
    case PENDING = 2;   // Payment is awaited on the issued invoice
    case PAID = 3;      // Invoice has been paid
    case OVERDUE = 4;   // Invoice payment is past the due date
    case CANCELLED = 5; // Invoice has been cancelled
    case REFUNDED = 6;  // Invoice payment has been refunded
}
