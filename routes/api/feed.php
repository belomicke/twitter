<?php

use App\Http\Controllers\Feed\GetFollowsPostsController;
use App\Http\Controllers\Feed\GetPostsByQueryController;
use App\Http\Controllers\Feed\GetUserLikedPostsController;
use App\Http\Controllers\Feed\GetUserPostsController;
use Illuminate\Support\Facades\Route;

Route::prefix('feed')->middleware('auth:sanctum')->group(function () {
    Route::get('timeline', GetFollowsPostsController::class);
    Route::get('user/{user:username}/posts', GetUserPostsController::class);
    Route::get('user/{user:username}/liked_posts', GetUserLikedPostsController::class);
    Route::get('query/posts', GetPostsByQueryController::class);
});
