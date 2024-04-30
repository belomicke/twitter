<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendVerificationCodeRequest;
use App\Repository\User\UserRepository;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class SendVerificationCodeController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly AuthService $authService
    ) {}

    public function __invoke(SendVerificationCodeRequest $request): JsonResponse
    {
        $email = $request->input('email');

        $userExists = $this->userRepository->checkUserWithEmailExists(email: $email);

        if ($userExists) {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => 'User with current email already exists.'
                ]
            ]);
        }

        $this->authService->sendVerificationCode(email: $email);

        return response()->json([
            'success' => true,
        ]);
    }
}
