<?php

use App\Http\Controllers\Account\CheckEmailExistsController;
use App\Http\Controllers\Account\CheckUsernameExistsController;
use App\Http\Controllers\Account\GetViewerController;
use Illuminate\Support\Facades\Route;

Route::prefix('account')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('viewer', GetViewerController::class);
    });

    Route::get('email_exists', CheckEmailExistsController::class);
    Route::get('username_exists', CheckUsernameExistsController::class);
});
