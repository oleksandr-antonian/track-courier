<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CourierTransportType extends Enum
{
    const Walking = 0;
    const Bicycle = 1;
    const Scooter = 2;
    const Vehicle = 3;

    public static function getDescription($value): string
    {
        return match ($value) {
            self::Walking => 'Walking',
            self::Bicycle => 'Bicycle / ElectricBike',
            self::Scooter => 'Scooter / ElectricScooter',
            self::Vehicle => 'Car / Motorcycle / Truck',
            default => self::getKey($value),
        };
    }
}
