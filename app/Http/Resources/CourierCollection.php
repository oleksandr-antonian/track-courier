<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CourierCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->items(),
            'current_page' => $this->currentPage(),
            'per_page' => $this->perPage(),
            'total' => $this->total(),
            'last_page' => $this->lastPage(),
        ];
    }
}
