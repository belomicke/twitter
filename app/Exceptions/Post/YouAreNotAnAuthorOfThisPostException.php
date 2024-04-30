<?php

namespace App\Exceptions\Post;

use Exception;
use Illuminate\Http\JsonResponse;

class YouAreNotAnAuthorOfThisPostException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Вы не являетесь создателем этого поста!'
        ]);
    }
}
