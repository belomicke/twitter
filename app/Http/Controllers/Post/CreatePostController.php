<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Services\Post\PostService;
use Exception;
use Illuminate\Http\JsonResponse;

class CreatePostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    public function __invoke(CreatePostRequest $request): JsonResponse
    {
        $text = $request->input('text');
        $retweetedPostId = $request->input('retweeted_post_id') ?? null;
        $inReplyToPostId = $request->input('in_reply_to_post_id') ?? null;

        try {
            $post = $this->postService->createPost(
                text: $text,
                retweetedPostId: $retweetedPostId,
                inReplyToPostId: $inReplyToPostId
            );
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'post' => $post
            ]
        ]);
    }
}
