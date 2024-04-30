<?php

use App\Http\Controllers\Feed\GetFollowsPostsController;
use App\Http\Controllers\Feed\GetPostCommentsController;
use App\Http\Controllers\Feed\GetPostsByQueryController;
use App\Http\Controllers\Feed\GetPostThreadController;
use App\Http\Controllers\Feed\GetPostThreadHistoryController;
use App\Http\Controllers\Feed\GetUserLikedPostsController;
use App\Http\Controllers\Feed\GetUserPostsController;
use Illuminate\Support\Facades\Route;

Route::prefix('feed')->middleware('auth:sanctum')->group(function () {
    Route::get('timeline', GetFollowsPostsController::class);

    Route::get('user/{username}/posts', GetUserPostsController::class);
    Route::get('user/{username}/favorited_posts', GetUserLikedPostsController::class);

    Route::get('post/{post}/comments', GetPostCommentsController::class);
    Route::get('post/{post}/thread', GetPostThreadController::class);
    Route::get('post/{post}/thread_history', GetPostThreadHistoryController::class);

    Route::get('query/posts', GetPostsByQueryController::class);
});
