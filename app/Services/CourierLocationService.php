<?php

namespace App\Services;

use App\Events\CourierLocationUpdated;
use App\Models\CourierLocation;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class CourierLocationService
{
    private const REDIS_KEY_PREFIX = 'courier:location:';

    public function updateLocation(int $courierId, float $latitude, float $longitude): void
    {
        $timestamp = Carbon::now()->timestamp;
        $redisKey = self::REDIS_KEY_PREFIX . $courierId;

        Redis::rpush($redisKey, json_encode([
            'lat' => $latitude,
            'lng' => $longitude,
            'timestamp' => $timestamp,
        ]));

        broadcast(new CourierLocationUpdated($courierId, $latitude, $longitude));
    }

    public function syncLocations(): void
    {
        $courierKeys = Redis::keys(self::REDIS_KEY_PREFIX . '*');

        foreach ($courierKeys as $courierKey) {
            $courierId = explode(':', $courierKey)[2];
            $redisKey = self::REDIS_KEY_PREFIX . $courierId;
            $courierLocations = Redis::lrange($redisKey, 0, -1);
            $this->saveLocations($courierId, $courierLocations);
            $this->cleanupRedis($courierId, $courierLocations);
        }
    }

    private function saveLocations(int $courierId, array $locations): void
    {
        $lastSavedLocation = null;

        foreach ($locations as $location) {
            $location = json_decode($location, true);
            $timestamp = Carbon::createFromTimestamp($location['timestamp']);

            if (!$lastSavedLocation || $lastSavedLocation['timestamp']->diffInMinutes($timestamp) > 4) {
                CourierLocation::create([
                    'courier_id' => $courierId,
                    'latitude' => $location['lat'],
                    'longitude' => $location['lng'],
                    'created_at' => $timestamp->toDateTimeString(),
                ]);
            }

            $lastSavedLocation = ['timestamp' => $timestamp];
        }
    }

    private function cleanupRedis(int $courierId, array $locations): void
    {
        $lastLocation = json_decode(end($locations), true);
        $timestamp = Carbon::createFromTimestamp($lastLocation['timestamp']);
        $redisKey = self::REDIS_KEY_PREFIX . $courierId;

        if (Carbon::now()->diffInHours($timestamp) > 1) {
            Redis::del($redisKey);
        } else {
            Redis::ltrim($redisKey, -1, -1);
        }
    }
}
