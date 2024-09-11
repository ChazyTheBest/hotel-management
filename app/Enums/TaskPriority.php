<?php declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumUtils;

enum TaskPriority: int
{
    use EnumUtils;

    case LOW = 0;
    case MEDIUM = 1;
    case HIGH = 2;
    case URGENT = 3;
}
