<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\CheckEmailExistsRequest;
use App\Repository\User\UserRepository;
use Illuminate\Http\JsonResponse;

class CheckEmailExistsController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function __invoke(CheckEmailExistsRequest $request): JsonResponse
    {
        $email = $request->input('email');

        $exists = $this->userRepository->checkUserWithEmailExists($email);

        return response()->json([
            'success' => true,
            'data' => [
                'exists' => $exists
            ]
        ]);
    }
}
