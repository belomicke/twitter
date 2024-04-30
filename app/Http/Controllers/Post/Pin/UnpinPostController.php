<?php

namespace App\Http\Controllers\Post\Pin;

use App\Exceptions\Post\Pin\PostIsNotPinnedAlreadyException;
use App\Exceptions\Post\YouAreNotAnAuthorOfThisPostException;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UnpinPostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    /**
     * @throws YouAreNotAnAuthorOfThisPostException
     * @throws PostIsNotPinnedAlreadyException
     */
    public function __invoke(Request $request, Post $post): JsonResponse
    {
        if (!Gate::allows('edit-post', $post)) {
            throw new YouAreNotAnAuthorOfThisPostException;
        }

        if ($post->is_pinned === false) {
            throw new PostIsNotPinnedAlreadyException;
        }

        $this->postService->unpinPost(post: $post);

        return response()->json([
            'success' => true
        ]);
    }
}
