<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\User\IncorrectCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateAccessTokenRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class CreateAccessTokenController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    /**
     * @throws IncorrectCredentialsException
     */
    public function __invoke(CreateAccessTokenRequest $request): JsonResponse
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $token = $this->authService->createAccessToken(
            username: $username,
            password: $password
        );

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token
            ]
        ]);
    }
}
