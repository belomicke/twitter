<?php

namespace App\Exceptions\Post\Favorite;

use Exception;
use Illuminate\Http\JsonResponse;

class PostNotInFavoriteAlreadyException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Вы не лайкали этот пост!'
        ]);
    }
}
