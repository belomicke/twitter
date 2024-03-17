<?php

use App\Http\Controllers\Post\CreatePostController;
use App\Http\Controllers\Post\GetPostByIdController;
use App\Http\Controllers\Post\LikePostController;
use App\Http\Controllers\Post\RetweetPostController;
use App\Http\Controllers\Post\UndoRetweetPostController;
use App\Http\Controllers\Post\UnlikePostController;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')->middleware('auth:sanctum')->group(function () {
    Route::get('{post}', GetPostByIdController::class);
    Route::post('{post}/like', LikePostController::class);
    Route::post('{post}/unlike', UnlikePostController::class);

    Route::post('{post}/retweet', RetweetPostController::class);
    Route::delete('{post}/retweet', UndoRetweetPostController::class);

    Route::post('create', CreatePostController::class);
});
