<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Devices\DeviceController;
use Inertia\Inertia;

Route::get('/', function () {
	return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	Route::prefix('device')->name('device.')->group(function () {
        Route::get('/', [DeviceController::class, 'index'])->name('index');
        Route::get('/new-device', [DeviceController::class, 'newDevice'])->name('new');
        Route::post('/store', [DeviceController::class, 'store'])->name('store');
    });
});

require __DIR__.'/auth.php';
