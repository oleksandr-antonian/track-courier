<?php

namespace App\Services;

use App\Enums\CourierTransportType;

class CourierTransportTypeService
{
    public function getAllTransportTypes(): array
    {
        return collect(CourierTransportType::getValues())
            ->map(fn($type) => [
                'value' => $type,
                'label' => CourierTransportType::getDescription($type),
            ])
            ->values()
            ->toArray();
    }
}
