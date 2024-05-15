<?php

namespace App\Http\Controllers\Post;

use App\Helpers\PostHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreateReplyRequest;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CreateReplyController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
        private readonly PostHelpers $postHelpers
    ) {}

    public function __invoke(CreateReplyRequest $request, Post $post): JsonResponse
    {
        if ($post->is_deleted) {
            throw new ModelNotFoundException();
        }

        $text = $request->input('text') ?? '';
        $files = $request->allFiles() ?? [];

        $post = $this->postService->createReply(
            post: $post,
            text: $text,
            media: $files['media'] ?? null
        );

        return response()->json([
            'success' => true,
            'data' => $this->postHelpers->postToJson(post: $post, freshPost: true)
        ]);
    }
}
