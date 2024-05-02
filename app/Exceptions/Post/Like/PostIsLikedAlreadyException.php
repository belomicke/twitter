<?php

namespace App\Exceptions\Post\Like;

use Exception;
use Illuminate\Http\JsonResponse;

class PostIsLikedAlreadyException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Вы уже лайкали этот пост!'
        ]);
    }
}
