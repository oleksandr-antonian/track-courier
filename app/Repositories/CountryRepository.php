<?php

namespace App\Repositories;

use App\Models\Country;
use Illuminate\Pagination\LengthAwarePaginator;

class CountryRepository
{
    public function getCountries($page, $perPage): LengthAwarePaginator
    {
        $query = Country::query();

        $query->orderBy('created_at', 'desc');
        $query->orderBy('id', 'desc');

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function getCountryById($id): Country
    {
        return Country::findOrFail($id);
    }
}
