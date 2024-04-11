<?php

namespace App\Exceptions\Post\Retweet;

use Exception;
use Illuminate\Http\JsonResponse;

class PostIsRetweetedAlreadyException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Вы уже ретвитнули этот пост!'
        ]);
    }
}
