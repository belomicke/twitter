<?php

namespace App\Http\Controllers\Post\Bookmark;

use App\Exceptions\Post\Bookmark\PostIsNotBookmarkedYetException;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UnbookmarkPostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    /**
     * @throws PostIsNotBookmarkedYetException
     */
    public function __invoke(Request $request, Post $post): JsonResponse
    {
        if (!Gate::allows('unbookmark-post', $post)) {
            throw new PostIsNotBookmarkedYetException;
        }

        $this->postService->unbookmarkPost(post: $post);

        return response()->json([
            'success' => true
        ]);
    }
}
