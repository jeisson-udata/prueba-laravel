<?php

use Illuminate\Support\Facades\Route;

/*
 * ResourceType CRUD
 */
Route::get('/api/resource-type', [\App\Http\Controllers\ResourceTypeController::class, 'index']);
Route::post('/api/resource-type', [\App\Http\Controllers\ResourceTypeController::class, 'store']);
Route::get('/api/resource-type/{resourceType}', [\App\Http\Controllers\ResourceTypeController::class, 'show']);
Route::put('/api/resource-type/{resourceType}', [\App\Http\Controllers\ResourceTypeController::class, 'update']);
Route::delete('/api/resource-type/{resourceType}', [\App\Http\Controllers\ResourceTypeController::class, 'destroy']);
Route::get('/api/resource-type/{resourceType}/resource', [\App\Http\Controllers\ResourceController::class, 'allByResourceType']);

/*
 * Resource CRUD
 */
Route::get('/api/resource', [\App\Http\Controllers\ResourceController::class, 'index']);
Route::post('/api/resource', [\App\Http\Controllers\ResourceController::class, 'store']);
Route::get('/api/resource/{resource}/reservation', [\App\Http\Controllers\ResourceController::class, 'reservations']);
Route::get('/api/resource/{resource}/availability', [\App\Http\Controllers\ResourceController::class, 'availability']);
Route::get('/api/resource/{resource}/availability/start/{start_at}/minutes/{minutes}', [\App\Http\Controllers\ResourceController::class, 'availabilityFromPeriod']);
Route::get('/api/resource/{resource}', [\App\Http\Controllers\ResourceController::class, 'show']);
Route::put('/api/resource/{resource}', [\App\Http\Controllers\ResourceController::class, 'update']);
Route::delete('/api/resource/{resource}', [\App\Http\Controllers\ResourceController::class, 'destroy']);


/*
 * Reservation CRUD
 */
Route::get('/api/reservation', [\App\Http\Controllers\ReservationController::class, 'index']);
Route::post('/api/reservation', [\App\Http\Controllers\ReservationController::class, 'store']);
Route::get('/api/reservation/{reservation}', [\App\Http\Controllers\ReservationController::class, 'show']);
Route::put('/api/reservation/{reservation}', [\App\Http\Controllers\ReservationController::class, 'update']);
Route::put('/api/reservation/{reservation}/start', [\App\Http\Controllers\ReservationController::class, 'start']);
Route::put('/api/reservation/{reservation}/complete', [\App\Http\Controllers\ReservationController::class, 'complete']);
Route::delete('/api/reservation/{reservation}', [\App\Http\Controllers\ReservationController::class, 'destroy']);
