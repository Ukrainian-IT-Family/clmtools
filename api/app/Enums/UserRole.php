<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum UserRole : string
{
    use EnumToArray;

    case NULL = 'null';
    case STUDENT = 'student';
    case LECTURER = 'lecturer';
    case ADMIN = 'admin';
}
