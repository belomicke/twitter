<?php

use App\Http\Controllers\Post\Bookmark\BookmarkPostController;
use App\Http\Controllers\Post\Bookmark\UnbookmarkPostController;
use App\Http\Controllers\Post\CreatePostController;
use App\Http\Controllers\Post\CreateQuoteController;
use App\Http\Controllers\Post\CreateReplyController;
use App\Http\Controllers\Post\DeletePostController;
use App\Http\Controllers\Post\Favorite\AddPostToFavoriteListController;
use App\Http\Controllers\Post\Favorite\RemovePostFromFavoriteListController;
use App\Http\Controllers\Post\GetPostByIdController;
use App\Http\Controllers\Post\Like\LikePostController;
use App\Http\Controllers\Post\Like\UnlikePostController;
use App\Http\Controllers\Post\Pin\PinPostController;
use App\Http\Controllers\Post\Pin\UnpinPostController;
use App\Http\Controllers\Post\Retweet\RetweetPostController;
use App\Http\Controllers\Post\Retweet\UndoRetweetPostController;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')->middleware('auth:sanctum')->group(function () {
    Route::get('{post}', GetPostByIdController::class);

    Route::post('{post}/like', LikePostController::class);
    Route::post('{post}/unlike', UnlikePostController::class);

    Route::post('{post}/bookmark', BookmarkPostController::class);
    Route::delete('{post}/bookmark', UnbookmarkPostController::class);

    Route::post('{post}/pin', PinPostController::class);
    Route::delete('{post}/pin', UnpinPostController::class);

    Route::post('{post}/retweet', RetweetPostController::class);
    Route::delete('{post}/retweet', UndoRetweetPostController::class);

    Route::post('{post}/favorite', AddPostToFavoriteListController::class);
    Route::delete('{post}/favorite', RemovePostFromFavoriteListController::class);

    Route::post('create', CreatePostController::class);
    Route::post('{post}/quote', CreateQuoteController::class);
    Route::post('{post}/reply', CreateReplyController::class);

    Route::delete('{post}', DeletePostController::class);
});
