<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourierResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'availability_status' => $this->availability_status,
            'transport_type' => $this->transport_type,
            'city' => new CityResource($this->city),
            'city_id' => $this->city_id,

        ];
    }
}
