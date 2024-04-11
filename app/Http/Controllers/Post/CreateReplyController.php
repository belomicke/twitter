<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreateReplyRequest;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;

class CreateReplyController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    public function __invoke(CreateReplyRequest $request, Post $post): JsonResponse
    {
        $text = $request->input('text');

        $post = $this->postService->createReply(
            post: $post,
            text: $text
        );

        return response()->json([
            'success' => true,
            'data' => [
                'post' => $post
            ]
        ]);
    }
}
