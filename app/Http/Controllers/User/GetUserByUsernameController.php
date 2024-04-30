<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repository\Account\ViewerRepository;
use App\Repository\User\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetUserByUsernameController extends Controller
{
    public function __construct(
        private readonly ViewerRepository $viewerRepository,
        private readonly UserRepository $userRepository
    ) {}

    public function __invoke(Request $request, string $username): JsonResponse
    {
        $viewer = $this->viewerRepository->getViewer();

        if ($viewer->username === $username) {
            $user = $viewer;
        } else {
            $user = $this->userRepository->getUserByUsername(username: $username);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user
            ]
        ]);
    }
}
