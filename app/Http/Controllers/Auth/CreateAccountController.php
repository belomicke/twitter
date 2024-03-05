<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateAccountRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateAccountController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function __invoke(CreateAccountRequest $request): JsonResponse
    {
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        $birth = $request->input('birth');

        $user = $this->userService->create(
            username: $username,
            email: $email,
            password: $password,
            birth: $birth
        );
        
        $user->save();

        DB::table('verification_codes')
            ->where('email', $email)
            ->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
