<?php

namespace App\Services;

use App\Http\Resources\CityCollection;
use App\Http\Resources\CityResource;
use App\Repositories\CityRepository;

class CityService
{
    protected CityRepository $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getCities($params): CityCollection
    {
        $perPage = $params['per_page'] ?? 10;
        $page = $params['page'] ?? 1;

        $filter = [
            'country_id' => $params['country_id'] ?? null,
        ];

        $cities = $this->cityRepository->getCities($page, $perPage, $filter);
        return new CityCollection($cities);
    }

    public function getCityById($id): CityResource
    {
        $city = $this->cityRepository->getCityById($id);
        return new CityResource($city);
    }
}
