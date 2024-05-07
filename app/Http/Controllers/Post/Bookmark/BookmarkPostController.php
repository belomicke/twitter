<?php

namespace App\Http\Controllers\Post\Bookmark;

use App\Exceptions\Post\Bookmark\PostIsBookmarkedAlreadyException;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BookmarkPostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    /**
     * @throws PostIsBookmarkedAlreadyException
     */
    public function __invoke(Request $request, Post $post): JsonResponse
    {
        if (!Gate::allows('bookmark-post', $post)) {
            throw new PostIsBookmarkedAlreadyException;
        }

        $this->postService->bookmarkPost(post: $post);

        return response()->json([
            'success' => true
        ]);
    }
}
