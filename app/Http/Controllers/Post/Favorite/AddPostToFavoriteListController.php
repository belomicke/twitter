<?php

namespace App\Http\Controllers\Post\Favorite;

use App\Exceptions\Post\Favorite\PostInFavoriteListAlreadyException;
use App\Exceptions\Post\YouAreNotAnAuthorOfThisPostException;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AddPostToFavoriteListController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
    ) {}

    /**
     * @throws YouAreNotAnAuthorOfThisPostException
     * @throws PostInFavoriteListAlreadyException
     */
    public function __invoke(Request $request, Post $post): JsonResponse
    {
        if ($post->is_deleted) {
            throw new ModelNotFoundException();
        }

        if (!Gate::allows('edit-post', $post)) {
            throw new YouAreNotAnAuthorOfThisPostException();
        }

        if ($post->is_favorite) {
            throw new PostInFavoriteListAlreadyException();
        }

        $this->postService->addPostToFavoriteList(post: $post);

        return response()->json([
            'success' => true
        ]);
    }
}
