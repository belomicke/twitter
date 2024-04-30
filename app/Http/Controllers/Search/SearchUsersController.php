<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Repository\User\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchUsersController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $query = $request->input('query');

        $users = $this->userRepository->searchUserByQuery(query: $query);

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $users,
                'total' => 20
            ]
        ]);
    }
}
