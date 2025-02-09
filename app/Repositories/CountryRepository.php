<?php

namespace App\Repositories;

use App\Models\Country;

class CountryRepository
{
    public function getCountries($page, $perPage): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Country::query();

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function getCountryById($id): Country
    {
        return Country::findOrFail($id);
    }
}
