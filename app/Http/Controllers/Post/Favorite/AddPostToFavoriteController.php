<?php

namespace App\Http\Controllers\Post\Favorite;

use App\Exceptions\Post\Favorite\PostInFavoriteAlreadyException;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class AddPostToFavoriteController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    /**
     * @throws PostInFavoriteAlreadyException
     */
    public function __invoke(Post $post): JsonResponse
    {
        if (!Gate::allows('add-post-to-favorite', $post)) {
            throw new PostInFavoriteAlreadyException;
        }

        $this->postService->addPostToFavorite(post: $post);

        return response()->json([
            'success' => true
        ]);
    }
}
