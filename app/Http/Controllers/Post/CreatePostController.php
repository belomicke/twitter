<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Services\Post\PostHelpers;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;

class CreatePostController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
        private readonly PostHelpers $postHelpers
    ) {}

    public function __invoke(CreatePostRequest $request): JsonResponse
    {
        $text = $request->input('text') ?? '';
        $files = $request->allFiles() ?? [];

        $post = $this->postService->createPost(
            text: $text,
            media: $files['media'] ?? null
        );

        return response()->json([
            'success' => true,
            'data' => $this->postHelpers->postToJson(post: $post, freshPost: true)
        ]);
    }
}
