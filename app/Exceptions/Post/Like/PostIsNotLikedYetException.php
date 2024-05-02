<?php

namespace App\Exceptions\Post\Like;

use Exception;
use Illuminate\Http\JsonResponse;

class PostIsNotLikedYetException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Вы не лайкали этот пост!'
        ]);
    }
}
