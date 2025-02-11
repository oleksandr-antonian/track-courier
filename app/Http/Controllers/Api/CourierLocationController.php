<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ResponseApiResource;
use App\Services\CourierLocationService;
use Illuminate\Http\Request;

class CourierLocationController
{
    protected CourierLocationService $courierLocationService;

    public function __construct(CourierLocationService $courierLocationService)
    {
        $this->courierLocationService = $courierLocationService;
    }

    public function store(Request $request, $courierId): ResponseApiResource
    {
        try {
            $latitude = $request->input('lat');
            $longitude = $request->input('lng');
            if (!$latitude || !$longitude) {
                return new ResponseApiResource(null, 'Latitude and longitude are required', null, 400);
            }
            $this->courierLocationService->store($courierId, $latitude, $longitude);
            return new ResponseApiResource(true, 'Location stored successfully');
        } catch (\Exception $e) {
            return new ResponseApiResource(null, 'An error occurred', $e->getMessage(), 500);
        }
    }
}
