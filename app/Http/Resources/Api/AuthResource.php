<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'user' => new UserResource($this['user']),
            'token' => $this['token'],
        ];
    }
}
