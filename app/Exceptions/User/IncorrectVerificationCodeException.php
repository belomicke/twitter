<?php

namespace App\Exceptions\User;

use Exception;
use Illuminate\Http\JsonResponse;

class IncorrectVerificationCodeException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Неверный код подтверждения!'
        ]);
    }
}
