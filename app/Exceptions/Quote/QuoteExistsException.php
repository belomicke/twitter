<?php

namespace App\Exceptions\Quote;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuoteExistsException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => [],
            'message' => 'Вы уже писали об этом!'
        ]);
    }
}
