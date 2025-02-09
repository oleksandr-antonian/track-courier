<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CourierRequest;
use App\Http\Resources\ResponseApiResource;
use App\Services\CourierAvailabilityStatusService;
use App\Services\CourierService;
use App\Services\CourierTransportTypeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CourierController
{
    protected CourierTransportTypeService $courierTransportTypeService;
    protected CourierAvailabilityStatusService $courierAvailabilityStatusService;
    protected CourierService $courierService;

    public function __construct(CourierTransportTypeService $courierTransportTypeService, CourierService $courierService, CourierAvailabilityStatusService $courierAvailabilityStatusService)
    {
        $this->courierTransportTypeService = $courierTransportTypeService;
        $this->courierAvailabilityStatusService = $courierAvailabilityStatusService;
        $this->courierService = $courierService;
    }

    public function getTransportTypes(): ResponseApiResource
    {
        try {
            $transportTypes = $this->courierTransportTypeService->getAllTransportTypes();
            return new ResponseApiResource($transportTypes, 'Transport types list');
        } catch (\Exception $e) {
            return new ResponseApiResource(null, 'An error occurred', $e->getMessage(), 500);
        }
    }

    public function getAvailabilityStatuses(): ResponseApiResource
    {
        try {
            $availabilityStatuses = $this->courierAvailabilityStatusService->getAllAvailabilityStatuses();
            return new ResponseApiResource($availabilityStatuses, 'Availability statuses list');
        } catch (\Exception $e) {
            return new ResponseApiResource(null, 'An error occurred', $e->getMessage(), 500);
        }
    }

    public function index(Request $request): ResponseApiResource
    {
        try {
            $params = $request->only(['city_id', 'page', 'per_page']);
            $couriers = $this->courierService->getCouriers($params);
            return new ResponseApiResource($couriers, 'Couriers list');
        } catch (\Exception $e) {
            return new ResponseApiResource(null, 'An error occurred', $e->getMessage(), 500);
        }
    }

    public function show($id): ResponseApiResource
    {
        try {
            $courier = $this->courierService->getCourierById($id);
            return new ResponseApiResource($courier, 'Courier info');
        } catch (ModelNotFoundException $e) {
            return new ResponseApiResource(null, 'Courier not found', $e->getMessage(), 404);
        } catch (\Exception $e) {
            return new ResponseApiResource(null, 'An error occurred', $e->getMessage(), 500);
        }
    }

    public function store(CourierRequest $request): ResponseApiResource
    {
        try {
            $courier = $this->courierService->createCourier($request->validated());
            return new ResponseApiResource($courier, 'Courier created', null, 201);
        } catch (\Exception $e) {
            return new ResponseApiResource(null, 'An error occurred', $e->getMessage(), 500);
        }
    }

    public function update(CourierRequest $request, $id): ResponseApiResource
    {
        try {
            $courier = $this->courierService->updateCourier($id, $request->validated());
            return new ResponseApiResource($courier, 'Courier updated');
        } catch (ModelNotFoundException $e) {
            return new ResponseApiResource(null, 'Courier not found', $e->getMessage(), 404);
        } catch (\Exception $e) {
            return new ResponseApiResource(null, 'An error occurred', $e->getMessage(), 500);
        }
    }

    public function destroy($id): ResponseApiResource
    {
        try {
            $result = $this->courierService->deleteCourier($id);
            return new ResponseApiResource($result, 'Courier deleted');
        } catch (ModelNotFoundException $e) {
            return new ResponseApiResource(null, 'Courier not found', $e->getMessage(), 404);
        } catch (\Exception $e) {
            return new ResponseApiResource(null, 'An error occurred', $e->getMessage(), 500);
        }
    }
}
