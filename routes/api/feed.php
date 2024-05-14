<?php

use App\Http\Controllers\Feed\GetBookmarkedPostsController;
use App\Http\Controllers\Feed\GetFollowsPostsController;
use App\Http\Controllers\Feed\GetPostRepliesController;
use App\Http\Controllers\Feed\GetPostsByQueryController;
use App\Http\Controllers\Feed\GetPostThreadHistoryController;
use App\Http\Controllers\Feed\GetUserFavoritePostsController;
use App\Http\Controllers\Feed\GetUserLikedPostsController;
use App\Http\Controllers\Feed\GetUserMediaPostsFeedController;
use App\Http\Controllers\Feed\GetUserPostsController;
use Illuminate\Support\Facades\Route;

Route::prefix('feed')->middleware('auth:sanctum')->group(function () {
    Route::get('timeline', GetFollowsPostsController::class);

    Route::get('user/{username}/posts', GetUserPostsController::class);
    Route::get('user/{username}/liked_posts', GetUserLikedPostsController::class);
    Route::get('user/{username}/media_posts', GetUserMediaPostsFeedController::class);
    Route::get('user/{username}/favorite_posts', GetUserFavoritePostsController::class);

    Route::get('post/{post}/replies', GetPostRepliesController::class);
    Route::get('post/{post}/thread_history', GetPostThreadHistoryController::class);

    Route::get('post/bookmarked', GetBookmarkedPostsController::class);

    Route::get('query/posts', GetPostsByQueryController::class);
});
