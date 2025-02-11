<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\CourierController;
use App\Http\Controllers\Api\CourierLocationController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::middleware('guest')->post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('cities', CityController::class)->only([
        'index', 'show'
    ]);
    Route::apiResource('countries', CountryController::class)->only([
        'index', 'show'
    ]);

    Route::get('/couriers/transport-types', [CourierController::class, 'getTransportTypes']);
    Route::get('/couriers/availability-statuses', [CourierController::class, 'getAvailabilityStatuses']);
    Route::apiResource('couriers', CourierController::class);

    Route::post('/couriers/{courier}/locations', [CourierLocationController::class, 'store']);
});

