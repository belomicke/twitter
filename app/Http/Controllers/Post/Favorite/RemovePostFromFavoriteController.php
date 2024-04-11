<?php

namespace App\Http\Controllers\Post\Favorite;

use App\Exceptions\Post\Favorite\PostNotInFavoriteAlreadyException;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class RemovePostFromFavoriteController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    /**
     * @throws PostNotInFavoriteAlreadyException
     */
    public function __invoke(Post $post): JsonResponse
    {
        if (!Gate::allows('remove-post-from-favorite', $post)) {
            throw new PostNotInFavoriteAlreadyException;
        }

        $this->postService->removePostFromFavorite(post: $post);

        return response()->json([
            'success' => true
        ]);
    }
}
