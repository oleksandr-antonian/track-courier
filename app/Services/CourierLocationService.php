<?php

namespace App\Services;

use App\Repositories\CourierLocationRedisRepository;
use App\Repositories\CourierLocationRepository;
use App\Repositories\CourierRepository;

class CourierLocationService
{
    private CourierLocationRedisRepository $redisRepository;
    private CourierLocationRepository $databaseRepository;
    private CourierRepository $courierRepository;

    public function __construct(
        CourierLocationRedisRepository $redisRepository,
        CourierLocationRepository $databaseRepository,
        CourierRepository $courierRepository
    ) {
        $this->redisRepository = $redisRepository;
        $this->databaseRepository = $databaseRepository;
        $this->courierRepository = $courierRepository;
    }

    public function show(int $courierId): ?array
    {
        $location = $this->redisRepository->getLatestLocation($courierId);
        if (!$location) {
            $location = $this->databaseRepository->getLatestLocation($courierId);
        }
        return $location;
    }

    public function store(int $courierId, float $latitude, float $longitude): void
    {
        $this->redisRepository->updateLocation($courierId, $latitude, $longitude);
    }

    public function syncLocations(): void
    {
        $courierIds = $this->redisRepository->getCourierIds();
        foreach ($courierIds as $courierId) {
            $locations = $this->redisRepository->getLocations($courierId);
            $this->databaseRepository->syncLocationsFromRedis($courierId, $locations);
            $this->redisRepository->cleanupLocation($courierId);
        }
    }

    public function getOnlineCouriersLocations(): array
    {
        $onlineCouriers = $this->courierRepository->getOnlineCouriers();
        $courierIds = $onlineCouriers->pluck('id')->toArray();
        $locations = $this->redisRepository->getLatestLocationsForCouriers($courierIds);
        $locations = $locations->map(function ($location) use ($onlineCouriers) {
            $courier = $onlineCouriers->firstWhere('id', $location['courier_id']);
            $location['courier_name'] = $courier->name;
            return $location;
        });
        return $locations->toArray();
    }
}
