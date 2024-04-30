<?php

namespace App\Exceptions\Post\Pin;

use Exception;
use Illuminate\Http\JsonResponse;

class PostIsPinnedAlreadyException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Пост уже закреплен!'
        ]);
    }
}
