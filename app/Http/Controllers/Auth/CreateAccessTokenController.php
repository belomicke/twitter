<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateAccessTokenRequest;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CreateAccessTokenController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function __invoke(CreateAccessTokenRequest $request): JsonResponse
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = $this->userRepository->getUserByUsername($username);

        if (!$user) {
            return response()->json([
                "message" => "Incorrect username or password."
            ], 422);
        }

        $passwordIsCorrect = Hash::check($password, $user->password);

        if ($passwordIsCorrect) {
            $credentials = [
                'username' => $username,
                'password' => $password
            ];

            $authWasSucceeded = Auth::attempt($credentials, true);

            if ($authWasSucceeded) {
                $user->tokens()->delete();
                $token = $user->createToken('token')->plainTextToken;

                return response()->json([
                    'success' => true,
                    'data' => [
                        'token' => $token
                    ]
                ]);
            }
        }

        return response()->json([
            "message" => "Incorrect username or password."
        ], 422);
    }
}
