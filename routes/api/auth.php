<?php

use App\Http\Controllers\Auth\CreateAccessTokenController;
use App\Http\Controllers\Auth\CreateAccountController;
use App\Http\Controllers\Auth\DeleteAccessTokenController;
use App\Http\Controllers\Auth\SendVerificationCodeController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('access_token', CreateAccessTokenController::class);

    Route::middleware('auth:sanctum')->group(function () {
        Route::delete('access_token', DeleteAccessTokenController::class);
    });

    Route::post('create_account', CreateAccountController::class);
    Route::post('send_verification_code', SendVerificationCodeController::class);
});
