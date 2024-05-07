<?php

namespace App\Exceptions\Post\Bookmark;

use Exception;
use Illuminate\Http\JsonResponse;

class PostIsBookmarkedAlreadyException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Вы уже добавили этот пост в закладки!'
        ]);
    }
}
