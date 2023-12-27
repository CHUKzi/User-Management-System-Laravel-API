<?php

use App\Http\Controllers\API\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('api')->prefix('/v1')->group(function () {
    // User Authentication
    Route::prefix('/users')->group(function () {
        Route::get('/', [UsersController::class, 'getUsers']);

/*         Route::post('/store', [UsersController::class, 'store']);
        Route::post('/auth', [UsersController::class, 'auth']);
        Route::post('/logout', [UsersController::class, 'logout'])->middleware('auth:api'); */
    });
});
