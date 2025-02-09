<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'iso_alpha_2' => $this->iso_alpha_2,
            'iso_alpha_3' => $this->iso_alpha_3,
        ];
    }
}
