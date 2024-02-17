<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class GetPostByIdController extends Controller
{
    public function __invoke(Post $post): JsonResponse
    {
        $user = User::query()->where('id', $post->user_id)->first();

        return response()->json([
            'success' => true,
            'data' => [
                'post' => $post,
                'user' => $user
            ]
        ]);
    }
}
