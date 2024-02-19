<?php

use App\Http\Controllers\Feed\GetUserPostsController;
use Illuminate\Support\Facades\Route;

Route::prefix('feed')->middleware('auth:sanctum')->group(function () {
    Route::get('user/{user:username}/posts', GetUserPostsController::class);
});
