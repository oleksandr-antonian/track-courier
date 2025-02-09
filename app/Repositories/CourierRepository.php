<?php

namespace App\Repositories;

use App\Models\Courier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CourierRepository
{
    public function getCouriers(int $page, int $perPage, array $filter = []): LengthAwarePaginator
    {
        $query = Courier::query();

        if (!empty($filter['city_id'])) {
            $query->where('city_id', $filter['city_id']);
        }

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
}
