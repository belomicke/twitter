<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;

class GetUserByUsernameController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function __invoke(string $username): JsonResponse
    {
        $user = $this->userService->getUserByUsername(username: $username);

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user
            ]
        ]);
    }
}
