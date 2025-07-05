<?php

use App\Http\Controllers\Api\SubscriptionSyncController;
use App\Http\Controllers\Api\UserSyncController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ActivityLogApiController;


Route::post('/users', [UserSyncController::class, 'store']);
Route::post('/subscriptions', [SubscriptionSyncController::class, 'store']);
Route::get('/activity-logs', [ActivityLogApiController::class, 'index']);
