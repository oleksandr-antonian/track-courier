<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class CourierAvailabilityStatus extends Enum
{
    const Offline = 0;
    const Online = 1;
    const Busy = 2;

    public static function getDescription($value): string
    {
        return match ($value) {
            self::Offline => 'Offline',
            self::Online => 'Online',
            self::Busy => 'Busy',
            default => self::getKey($value),
        };
    }
}

