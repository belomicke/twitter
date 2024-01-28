<?php

use App\Http\Controllers\Account\CheckEmailExistsController;
use App\Http\Controllers\Account\CheckUsernameExistsController;
use App\Http\Controllers\Account\GetCurrentUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('account')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('current_user', GetCurrentUserController::class);
    });

    Route::get('email_exists', CheckEmailExistsController::class);
    Route::get('username_exists', CheckUsernameExistsController::class);
});
