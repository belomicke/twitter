<?php

use App\Http\Controllers\Follows\FollowUserController;
use App\Http\Controllers\Follows\UnfollowUserController;
use App\Http\Controllers\User\GetUserByUsernameController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('{user:username}/follow', FollowUserController::class);
        Route::post('{user:username}/unfollow', UnfollowUserController::class);

        Route::get('{user:username}', GetUserByUsernameController::class);
    });
});
