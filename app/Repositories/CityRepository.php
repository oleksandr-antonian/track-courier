<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Pagination\LengthAwarePaginator;

class CityRepository
{
    public function getCities($page, $perPage, $filter = []): LengthAwarePaginator
    {
        $query = City::query();

        if (!empty($filter['country_id'])) {
            $query->where('country_id', $filter['country_id']);
        }

        $query->orderBy('created_at', 'desc');
        $query->orderBy('id', 'desc');

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function getCityById($id): City
    {
        return City::findOrFail($id);
    }
}
