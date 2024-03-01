<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\UnlikePostRequest;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;

class UnlikePostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    public function __invoke(UnlikePostRequest $request, Post $post): JsonResponse
    {
        $this->postService->unlike(post: $post);

        return response()->json([
            'success' => true
        ]);
    }
}
