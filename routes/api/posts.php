<?php

use App\Http\Controllers\Post\CreatePostController;
use App\Http\Controllers\Post\GetPostByIdController;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')->middleware('auth:sanctum')->group(function () {
    Route::get('{post}', GetPostByIdController::class);
    Route::post('create', CreatePostController::class);
});
