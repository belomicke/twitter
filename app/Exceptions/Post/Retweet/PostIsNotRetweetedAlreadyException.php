<?php

namespace App\Exceptions\Post\Retweet;

use Exception;
use Illuminate\Http\JsonResponse;

class PostIsNotRetweetedAlreadyException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Вы ещё не ретвитнули этот пост!'
        ]);
    }
}
