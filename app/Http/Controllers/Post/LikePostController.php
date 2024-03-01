<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\LikePostRequest;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;

class LikePostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    public function __invoke(LikePostRequest $request, Post $post): JsonResponse
    {
        $this->postService->like(post: $post);

        return response()->json([
            'success' => true
        ]);
    }
}
