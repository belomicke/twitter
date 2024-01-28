<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendVerificationCodeRequest;
use App\Jobs\VerificationCodeEmailJob;
use App\Models\User;
use App\Services\VerificationCode\VerificationCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SendVerificationCodeController extends Controller
{
    public function __invoke(SendVerificationCodeRequest $request): JsonResponse
    {
        $email = $request->input('email');

        $userExists = User::query()
            ->orWhere('email', $email)
            ->exists();

        if ($userExists) {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => 'User with current email already exists.'
                ]
            ]);
        }

        $entity = DB::table('verification_codes')->where('email', $email)->first();

        if (!$entity) {
            $code = VerificationCodeService::generateVerificationCode();

            $entity = DB::table('verification_codes')->insert([
                'email' => $email,
                'code' => $code
            ]);
        } else {
            $code = $entity->code;
        }

        if ($entity) {
            VerificationCodeEmailJob::dispatch(
                email: $email,
                code: $code
            );

            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }
}
