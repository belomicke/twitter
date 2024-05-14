<?php

namespace App\Exceptions\Post\Favorite;

use Exception;
use Illuminate\Http\JsonResponse;

class PostNotInFavoriteListYetException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Вы ещё не добавляли этот пост в свой список избранных!'
        ]);
    }
}
