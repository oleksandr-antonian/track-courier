<?php

namespace App\Services;

use App\Http\Resources\CountryCollection;
use App\Http\Resources\CountryResource;
use App\Repositories\CountryRepository;

class CountryService
{
    protected CountryRepository $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function getCountries($params): CountryCollection
    {
        $perPage = $params['per_page'] ?? 10;
        $page = $params['page'] ?? 1;

        $countries = $this->countryRepository->getCountries($page, $perPage);
        return new CountryCollection($countries);
    }

    public function getCountryById($id): CountryResource
    {
        $country = $this->countryRepository->getCountryById($id);
        return new CountryResource($country);
    }
}
