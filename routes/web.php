<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Devices\DeviceController;
use App\Http\Controllers\Floors\FloorController;
use Inertia\Inertia;

Route::get('/', function () {
	return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/devices', [DashboardController::class, 'data'])->name('devices');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	Route::prefix('device')->name('device.')->group(function () {
        Route::get('/', [DeviceController::class, 'index'])->name('index');
        Route::get('/create', [DeviceController::class, 'create'])->name('new');
        Route::post('/store', [DeviceController::class, 'store'])->name('store');
    });
	
	Route::prefix('floors')->name('floors.')->group(function () {
		Route::get('/list', [FloorController::class, 'list'])->name('list');
		Route::get('/searc', [FloorController::class, 'search'])->name('search');
    });
});

require __DIR__.'/auth.php';
