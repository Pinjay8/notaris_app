<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserSyncController;

Route::post('/users', [UserSyncController::class, 'store']);
