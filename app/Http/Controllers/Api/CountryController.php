<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseApiResource;
use App\Services\CountryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index(Request $request): ResponseApiResource
    {
        try {
            $params = $request->only(['country_id', 'page', 'per_page']);
            $countries = $this->countryService->getCountries($params);
            return new ResponseApiResource($countries, 'Countries list');
        } catch (\Exception $e) {
            return new ResponseApiResource(null, 'An error occurred', $e->getMessage(), 500);
        }
    }

    public function show($id) : ResponseApiResource
    {
        try {
            $country = $this->countryService->getCountryById($id);
            return new ResponseApiResource($country, 'Country info');
        } catch (ModelNotFoundException $e) {
            return new ResponseApiResource(null, 'Country not found', $e->getMessage(), 404);
        } catch (\Exception $e) {
            return new ResponseApiResource(null, 'An error occurred', $e->getMessage(), 500);
        }
    }
}
