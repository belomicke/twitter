<?php

namespace App\Exceptions\Post\Favorite;

use Exception;
use Illuminate\Http\JsonResponse;

class PostInFavoriteListAlreadyException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Этот пост уже находится в вашем списке избранных!'
        ]);
    }
}
