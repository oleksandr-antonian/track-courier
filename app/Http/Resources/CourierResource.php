<?php

namespace App\Http\Resources;

use App\Services\CourierLocationService;
use Illuminate\Http\Resources\Json\JsonResource;

class CourierResource extends JsonResource
{
    public function toArray($request): array
    {
        $location = app(CourierLocationService::class)->show($this->id);

        if (!$location) {
            $location = [
                'lat' => $this->city->latitude,
                'lng' => $this->city->longitude,
                'timestamp' => now()->timestamp,
            ];
        }

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'availability_status' => $this->availability_status,
            'transport_type' => $this->transport_type,
            'city_id' => $this->city_id,
            'city_name' => $this->city->name,
            'location' => $location,
        ];
    }
}
