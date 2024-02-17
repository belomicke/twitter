<?php

use App\Http\Controllers\User\GetUserByUsernameController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('{user:username}', GetUserByUsernameController::class);
    });
});
