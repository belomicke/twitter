<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteAccessTokenController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        Auth::guard('sanctum')->user()->tokens()->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
