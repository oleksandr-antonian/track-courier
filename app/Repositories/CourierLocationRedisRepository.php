<?php

namespace App\Repositories;

use App\Events\CourierLocationUpdated;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

class CourierLocationRedisRepository
{
    public const REDIS_KEY_PREFIX = 'courier:location:';

    public function getCourierIds(): array
    {
        $keys = Redis::keys(self::REDIS_KEY_PREFIX . '*');
        $courierIds = [];

        foreach ($keys as $key) {
            $courierIds[] = (int) explode(':', $key)[2];
        }

        return $courierIds;
    }

    public function getLocations(int $courierId): array
    {
        $redisKey = self::REDIS_KEY_PREFIX . $courierId;
        $locations = Redis::lrange($redisKey, 0, -1);

        return array_map(function ($location) {
            return json_decode($location, true);
        }, $locations);
    }

    public function updateLocation(int $courierId, float $latitude, float $longitude): void
    {
        $timestamp = now()->timestamp;
        $redisKey = self::REDIS_KEY_PREFIX . $courierId;

        Redis::rpush($redisKey, json_encode([
            'lat' => $latitude,
            'lng' => $longitude,
            'timestamp' => $timestamp,
        ]));

        event(new CourierLocationUpdated($courierId, $latitude, $longitude));
    }

    public function getLatestLocation(int $courierId): ?array
    {
        $redisKey = self::REDIS_KEY_PREFIX . $courierId;
        $lastLocation = Redis::lrange($redisKey, -1, -1);

        if (!empty($lastLocation)) {
            return json_decode($lastLocation[0], true);
        }

        return null;
    }

    public function cleanupLocation(int $courierId): void
    {
        $redisKey = self::REDIS_KEY_PREFIX . $courierId;
        $locations = Redis::lrange($redisKey, 0, -1);

        $lastLocation = json_decode(end($locations), true);
        $timestamp = Carbon::createFromTimestamp($lastLocation['timestamp']);

        if (Carbon::now()->diffInHours($timestamp) > 1) {
            Redis::del($redisKey);
        } else {
            Redis::ltrim($redisKey, -1, -1);
        }
    }

    public function getLatestLocationsForCouriers(array $courierIds): Collection
    {
        $locations = collect();

        foreach ($courierIds as $courierId) {
            $lastLocation = $this->getLatestLocation($courierId);

            if ($lastLocation) {
                $locations->push(array_merge($lastLocation, ['courier_id' => $courierId]));
            }
        }

        return $locations;
    }
}
