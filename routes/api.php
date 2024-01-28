<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require_once 'api/account.php';
require_once 'api/auth.php';

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
