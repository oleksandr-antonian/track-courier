<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseApiResource;
use App\Services\CityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function index(Request $request): ResponseApiResource
    {
        try {
            $params = $request->only(['country_id', 'page', 'per_page']);
            $cities = $this->cityService->getCities($params);
            return new ResponseApiResource($cities, 'Cities list');
        } catch (\Exception $e) {
            return new ResponseApiResource(null, 'An error occurred', $e->getMessage(), 500);
        }
    }

    public function show($id) : ResponseApiResource
    {
        try {
            $city = $this->cityService->getCityById($id);
            return new ResponseApiResource($city, 'City info');
        } catch (ModelNotFoundException $e) {
            return new ResponseApiResource(null, 'City not found', $e->getMessage(), 404);
        } catch (\Exception $e) {
            return new ResponseApiResource(null, 'An error occurred', $e->getMessage(), 500);
        }
    }
}
