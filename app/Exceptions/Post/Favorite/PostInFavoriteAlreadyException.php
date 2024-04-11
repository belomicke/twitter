<?php

namespace App\Exceptions\Post\Favorite;

use Exception;
use Illuminate\Http\JsonResponse;

class PostInFavoriteAlreadyException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Вы уже лайкали этот пост!'
        ]);
    }
}
