<?php

namespace App\Exceptions\User;

use Exception;
use Illuminate\Http\JsonResponse;

class IncorrectCredentialsException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Неверный логин или пароль!'
        ]);
    }
}
