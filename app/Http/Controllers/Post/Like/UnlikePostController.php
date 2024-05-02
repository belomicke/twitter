<?php

namespace App\Http\Controllers\Post\Like;

use App\Exceptions\Post\Like\PostIsNotLikedYetException;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class UnlikePostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    /**
     * @throws PostIsNotLikedYetException
     */
    public function __invoke(Post $post): JsonResponse
    {
        if (!Gate::allows('unlike-post', $post)) {
            throw new PostIsNotLikedYetException;
        }

        $this->postService->unlikePost(post: $post);

        return response()->json([
            'success' => true
        ]);
    }
}
