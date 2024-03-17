<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RetweetPostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    public function __invoke(Request $request, Post $post): JsonResponse
    {
        $post = $this->postService->retweet($post);
        $user = User::query()->where('id', $post->user_id)->first();
        $retweet = null;

        if ($post->retweeted_post_id !== null) {
            $retweetEntity = [];

            $retweetEntity['post'] = Post::query()
                ->where('id', $post->retweeted_post_id)
                ->first();
            $retweetEntity['user'] = User::query()
                ->where('id', $retweetEntity['post']->user_id)
                ->first();

            $retweet = $retweetEntity;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'post' => $post,
                'user' => $user,
                'extensions' => [
                    'retweet' => $retweet
                ]
            ]
        ]);
    }
}
