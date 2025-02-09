<?php

namespace App\Services;

use App\Http\Resources\CourierCollection;
use App\Http\Resources\CourierResource;
use App\Repositories\CourierRepository;

class CourierService
{
    protected CourierRepository $courierRepository;

    public function __construct(CourierRepository $courierRepository)
    {
        $this->courierRepository = $courierRepository;
    }

    public function getCouriers($params): CourierCollection
    {
        $perPage = $params['per_page'] ?? 10;
        $page = $params['page'] ?? 1;

        $filter = [
            'city_id' => $params['city_id'] ?? null,
        ];
        $couriers = $this->courierRepository->getCouriers($page, $perPage, $filter);
        return new CourierCollection($couriers);
    }

    public function getCourierById(int $id): CourierResource
    {
        $courier = $this->courierRepository->getCourierById($id);
        return new CourierResource($courier);
    }

    public function createCourier(array $data): CourierResource
    {
        $courier = $this->courierRepository->createCourier($data);
        return new CourierResource($courier);
    }

    public function updateCourier(int $id, array $data): ?CourierResource
    {
        $courier = $this->courierRepository->getCourierById($id);
        $this->courierRepository->updateCourier($courier, $data);
        return new CourierResource($courier);
    }

    public function deleteCourier(int $id): bool
    {
        $courier = $this->courierRepository->getCourierById($id);
        return $this->courierRepository->deleteCourier($courier);
    }
}
