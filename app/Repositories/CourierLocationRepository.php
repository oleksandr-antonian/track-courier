<?php

namespace App\Repositories;

use App\Models\CourierLocation;
use Carbon\Carbon;

class CourierLocationRepository
{
    public function saveLocation(int $courierId, float $latitude, float $longitude, int $timestamp): void
    {
        $timestamp = Carbon::createFromTimestamp($timestamp);

        CourierLocation::create([
            'courier_id' => $courierId,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'created_at' => $timestamp->toDateTimeString(),
        ]);
    }

    public function syncLocationsFromRedis(int $courierId, array $locations): void
    {
        $lastSavedLocation = null;

        foreach ($locations as $location) {
            $timestamp = Carbon::createFromTimestamp($location['timestamp']);

            if (!$lastSavedLocation || $lastSavedLocation['timestamp']->diffInMinutes($timestamp) > 4) {
                $this->saveLocation($courierId, $location['lat'], $location['lng'], $location['timestamp']);
            }

            $lastSavedLocation = ['timestamp' => $timestamp];
        }
    }

    public function getLatestLocation(int $courierId): ?array
    {
        $location = CourierLocation::where('courier_id', $courierId)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($location) {
            return [
                'lat' => $location->latitude,
                'lng' => $location->longitude,
                'timestamp' => Carbon::parse($location->created_at)->timestamp,
            ];
        }

        return null;
    }
}
