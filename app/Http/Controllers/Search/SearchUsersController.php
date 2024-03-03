<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchUsersController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $query = $request->input('query');

        $users = User::search($query)->take(20)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $users,
                'total' => 20
            ]
        ]);
    }
}
