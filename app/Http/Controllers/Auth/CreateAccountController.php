<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\User\IncorrectVerificationCodeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateAccountRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class CreateAccountController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    /**
     * @throws IncorrectVerificationCodeException
     */
    public function __invoke(CreateAccountRequest $request): JsonResponse
    {
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        $birth = $request->input('birth');
        $code = $request->input('code');

        $this->authService->createAccount(
            username: $username,
            email: $email,
            password: $password,
            birth: $birth,
            code: $code
        );

        return response()->json([
            'success' => true
        ]);
    }
}
