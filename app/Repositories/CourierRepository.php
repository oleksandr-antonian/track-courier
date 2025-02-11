<?php

namespace App\Repositories;

use App\Enums\CourierAvailabilityStatus;
use App\Models\Courier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CourierRepository
{
    private function applyFilters(Builder $query, array $filter): void
    {
        if (!empty($filter['city_id'])) {
            $query->where('city_id', $filter['city_id']);
        }

        if (!empty($filter['availability_status'])) {
            $query->where('availability_status', $filter['availability_status']);
        }
    }

    public function getCouriers(int $page, int $perPage, array $filter = []): LengthAwarePaginator
    {
        $query = Courier::query();

        $this->applyFilters($query, $filter);

        $query->orderBy('created_at', 'desc');
        $query->orderBy('id', 'desc');

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function getCourierById(int $id): Courier
    {
        return Courier::findOrFail($id);
    }

    public function createCourier(array $data): Courier
    {
        return Courier::create($data);
    }

    public function updateCourier(Courier $courier, array $data): bool
    {
        return $courier->update($data);
    }

    public function deleteCourier(Courier $courier): bool
    {
        return $courier->delete();
    }

    public function getAllCouriers(array $filter = []): Collection
    {
        $query = Courier::query();

        $this->applyFilters($query, $filter);

        return $query->get();
    }

    public function getOnlineCouriers(): Collection
    {
        return $this->getAllCouriers(['availability_status' => CourierAvailabilityStatus::Online]);
    }
}
