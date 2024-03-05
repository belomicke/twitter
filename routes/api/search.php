<?php

use App\Http\Controllers\Search\SearchPostsController;
use App\Http\Controllers\Search\SearchUsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('search')->middleware('auth:sanctum')->group(function () {
    Route::get('users', SearchUsersController::class);
    Route::get('posts', SearchPostsController::class);
});
