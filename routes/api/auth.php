<?php

use App\Http\Controllers\Auth\CreateAccessTokenController;
use App\Http\Controllers\Auth\CreateAccountController;
use App\Http\Controllers\Auth\SendVerificationCodeController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('create_account', CreateAccountController::class);
    Route::post('create_access_token', CreateAccessTokenController::class);
    Route::post('send_verification_code', SendVerificationCodeController::class);
});
