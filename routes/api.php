<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Devices\HumidityController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', [HumidityController::class, 'check']);

Route::prefix('devices')->name('devices.')->group(function () {
	Route::post('/humidity', [HumidityController::class, 'humidity'])->name('humidity');
});
