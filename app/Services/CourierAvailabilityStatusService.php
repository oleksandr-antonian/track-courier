<?php

namespace App\Services;

use App\Enums\CourierAvailabilityStatus;

class CourierAvailabilityStatusService
{
    public function getAllAvailabilityStatuses(): array
    {
        return collect(CourierAvailabilityStatus::getValues())
            ->map(fn($status) => [
                'value' => $status,
                'label' => CourierAvailabilityStatus::getDescription($status),
            ])
            ->values()
            ->toArray();
    }
}
