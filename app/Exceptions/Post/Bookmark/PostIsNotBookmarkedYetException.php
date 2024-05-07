<?php

namespace App\Exceptions\Post\Bookmark;

use Exception;
use Illuminate\Http\JsonResponse;

class PostIsNotBookmarkedYetException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Вы ещё не добавляли этот пост в закладки!'
        ]);
    }
}
