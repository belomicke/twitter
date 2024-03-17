<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UndoRetweetPostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    public function __invoke(Request $request, Post $post): JsonResponse
    {
        $result = $this->postService->undoRetweet($post);

        return response()->json([
            'success' => $result
        ]);
    }
}
