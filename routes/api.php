<?php

use App\Http\Controllers\API\AuthenticatedSessionController;
use App\Http\Controllers\API\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('api')->prefix('/v1')->group(function () {

    // Authentication
    Route::prefix('/auth')->group(function () {
        Route::post('/', [AuthenticatedSessionController::class, 'auth']);
        Route::post('logout', [AuthenticatedSessionController::class, 'logout'])->middleware('auth:api');
        Route::get('me', [AuthenticatedSessionController::class, 'authMe'])->middleware('auth:api');
    });

    // Users
    Route::prefix('/users')->group(function () {
        Route::get('/', [UsersController::class, 'getUsers']);
        Route::get('/find', [UsersController::class, 'getUser']);
        Route::post('/store', [UsersController::class, 'store']);
        Route::put('/update/{id}', [UsersController::class, 'update']);
        Route::delete('/delete/{id}', [UsersController::class, 'destroy']);
    });
});
