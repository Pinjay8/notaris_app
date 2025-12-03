<?php

use App\Http\Controllers\Api\SubscriptionSyncController;
use App\Http\Controllers\Api\UserSyncController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ActivityLogApiController;
use App\Http\Controllers\Api\NotarisController;
use App\Http\Controllers\Api\SummaryNotarisController;

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/users', [UserSyncController::class, 'store']);
//     Route::post('/subscriptions', [SubscriptionSyncController::class, 'store']);
//     Route::get('/activity-logs', [ActivityLogApiController::class, 'index']);
// });



Route::middleware('auth.token')->group(function () {
    Route::get('/get-users', [UserSyncController::class, 'index']);
    Route::post('/users', [UserSyncController::class, 'store']);
    Route::post('/subscriptions', [SubscriptionSyncController::class, 'store']);
    Route::get('subscriptions', [SubscriptionSyncController::class, 'index']);
    Route::get('/activity-logs', [ActivityLogApiController::class, 'index']);
    Route::get('/notaris', [NotarisController::class, 'index']);

    // Notaris Summary
    Route::get('/notaris/summary', [SummaryNotarisController::class, 'index']);
    Route::get('/notaris/summary/{id}', [SummaryNotarisController::class, 'filter']);

    Route::get('/get-all-clients', [SummaryNotarisController::class, 'allClients']);
    Route::get('/notaris/clients/{id}', [SummaryNotarisController::class, 'clientsByNotaris']);
});
