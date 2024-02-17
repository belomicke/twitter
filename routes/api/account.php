<?php

use App\Http\Controllers\Account\CheckEmailExistsController;
use App\Http\Controllers\Account\CheckUsernameExistsController;
use App\Http\Controllers\Account\EditAccountPublicData;
use App\Http\Controllers\Account\GetViewerController;
use App\Http\Controllers\Account\ProfileBanner\ChangeProfileBannerController;
use App\Http\Controllers\Account\ProfileBanner\DeleteProfileBannerController;
use App\Http\Controllers\Account\ProfilePicture\ChangeProfilePictureController;
use App\Http\Controllers\Account\ProfilePicture\DeleteProfilePictureController;
use Illuminate\Support\Facades\Route;

Route::prefix('account')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('profile_banner')->group(function () {
            Route::post('', ChangeProfileBannerController::class);
            Route::delete('', DeleteProfileBannerController::class);
        });

        Route::prefix('profile_picture')->group(function () {
            Route::post('', ChangeProfilePictureController::class);
            Route::delete('', DeleteProfilePictureController::class);
        });

        Route::patch('edit_public_data', EditAccountPublicData::class);
        Route::get('viewer', GetViewerController::class);
    });

    Route::get('email_exists', CheckEmailExistsController::class);
    Route::get('username_exists', CheckUsernameExistsController::class);
});
