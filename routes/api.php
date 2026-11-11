<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\ItemCategoryAPIController;
use App\Http\Controllers\API\ItemUnitAPIController;
use App\Http\Controllers\API\ItemAPIController;
use App\Http\Controllers\API\BookingPaymentAPIController;
use App\Http\Controllers\API\ProducerPartyAPIController;
use App\Http\Controllers\API\NocPaymentAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Register API routes for default User guard authentication.
| Producer auth is excluded as requested.
|
*/

// Login Endpoint
Route::post('/login', [AuthAPIController::class, 'login']);

// Protected Routes (Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthAPIController::class, 'logout']);
    Route::get('/me', [AuthAPIController::class, 'me']);

    // Item Categories API
    Route::get('/item_categories', [ItemCategoryAPIController::class, 'index']);
    Route::get('/item_categories/{id}', [ItemCategoryAPIController::class, 'show']);

    // Item Units API
    Route::get('/item_units', [ItemUnitAPIController::class, 'index']);
    Route::get('/item_units/{id}', [ItemUnitAPIController::class, 'show']);

    // Items API
    Route::get('/items', [ItemAPIController::class, 'index']);
    Route::get('/items/{id}', [ItemAPIController::class, 'show']);

    // Parties / Producers API
    Route::get('/parties', [ProducerPartyAPIController::class, 'index']);
    Route::get('/parties/{id}', [ProducerPartyAPIController::class, 'show']);

    // Booking Payments API (Pull & Push)
    Route::get('/booking-payments', [BookingPaymentAPIController::class, 'index']);
    Route::get('/booking-payments/{trn_id}', [BookingPaymentAPIController::class, 'show']);
    Route::post('/booking-payments/push', [BookingPaymentAPIController::class, 'pushManual']);

    // NOC Payments API
    Route::get('/noc-payments', [NocPaymentAPIController::class, 'index']);
    Route::get('/noc-payments/{identifier}', [NocPaymentAPIController::class, 'show']);
    Route::post('/noc-payments/push', [NocPaymentAPIController::class, 'pushManual']);
});
