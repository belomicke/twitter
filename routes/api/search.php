<?php

use App\Http\Controllers\Search\SearchUsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('search')->middleware('auth:sanctum')->group(function () {
    Route::get('users', SearchUsersController::class);
});
