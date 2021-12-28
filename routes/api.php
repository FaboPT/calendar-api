<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1')->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('availabilities')->group(function () {
        Route::post('', [AvailabilityController::class, 'store'])->name('availability.store')->middleware('availability.created');
        Route::put('/{id}', [AvailabilityController::class, 'update'])->name('availability.update')->middleware('permission.edit:availabilities');
        Route::delete('/{id}', [AvailabilityController::class, 'destroy'])->name('availability.update')->middleware('permission.edit:availabilities');
        Route::get('', [AvailabilityController::class, 'index'])->name('availability.index');

    });

    Route::prefix('events')->group(function () {
        Route::post('', [EventController::class, 'store'])->name('event.store')->middleware('event.check');
        Route::put('/{id}', [EventController::class, 'update'])->name('event.update')->middleware(['permission.edit:events', 'event.check']);
        Route::delete('/{id}', [EventController::class, 'destroy'])->name('event.destroy')->middleware('permission.edit:events');
    });

});
