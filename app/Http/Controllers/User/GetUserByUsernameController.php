<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetUserByUsernameController extends Controller
{
    public function __invoke(Request $request, User $user): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user
            ]
        ]);
    }
}
