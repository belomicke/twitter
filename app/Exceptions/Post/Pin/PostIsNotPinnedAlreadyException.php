<?php

namespace App\Exceptions\Post\Pin;

use Exception;
use Illuminate\Http\JsonResponse;

class PostIsNotPinnedAlreadyException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Вы не закрепляли этот пост!'
        ]);
    }
}
