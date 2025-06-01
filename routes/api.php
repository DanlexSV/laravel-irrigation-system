<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Devices\HumidityController;
use App\Http\Controllers\Api\Devices\WateringController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', [HumidityController::class, 'check']);

Route::prefix('devices')->name('devices.')->group(function () {
	Route::post('/humidity', [HumidityController::class, 'humidity'])->name('humidity');

	Route::prefix('watering')->name('watering.')->group(function () {
        Route::post('/check', [WateringController::class, 'checkWatering'])->name('check');
        Route::post('/auto', [WateringController::class, 'registerAutoWatering'])->name('auto');
    });
});
