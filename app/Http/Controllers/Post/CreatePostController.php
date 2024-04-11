<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;

class CreatePostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    public function __invoke(CreatePostRequest $request): JsonResponse
    {
        $text = $request->input('text');

        $post = $this->postService->createPost(
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
