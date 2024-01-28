<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\CheckUsernameExistsRequest;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;

class CheckUsernameExistsController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function __invoke(CheckUsernameExistsRequest $request): JsonResponse
    {
        $username = $request->input('username');

        $exists = $this->userRepository->checkUserWithUsernameExists($username);

        return response()->json([
            'success' => true,
            'data' => [
                'exists' => $exists
            ]
        ]);
    }
}
