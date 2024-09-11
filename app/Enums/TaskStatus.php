<?php declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumUtils;

enum TaskStatus: int
{
    use EnumUtils;

    case PENDING = 0;       // Task is created but not yet assigned or started
    case ASSIGNED = 1;      // Task has been assigned to someone
    case IN_PROGRESS = 2;   // Task is currently being worked on
    case ON_HOLD = 3;       // Task is paused or waiting for something
    case REVIEW = 4;        // Task is completed but under review
    case COMPLETED = 5;     // Task is finished
    case CANCELLED = 6;     // Task is cancelled and should not be processed further
}
