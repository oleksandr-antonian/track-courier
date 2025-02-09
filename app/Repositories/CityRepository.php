<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository
{
    public function getCities($page, $perPage, $filter = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = City::query();

        if (!empty($filter['country_id'])) {
            $query->where('country_id', $filter['country_id']);
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function getCityById($id): City
    {
        return City::findOrFail($id);
    }
}
