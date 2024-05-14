<?php

namespace App\Http\Controllers\Post;

use App\Exceptions\Post\YouAreNotAnAuthorOfThisPostException;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DeletePostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    /**
     * @throws YouAreNotAnAuthorOfThisPostException
     */
    public function __invoke(Request $request, Post $post): JsonResponse
    {
        if ($post->is_deleted) {
            throw new ModelNotFoundException();
        }

        if (!Gate::allows('edit-post', $post)) {
            throw new YouAreNotAnAuthorOfThisPostException();
        }

        $this->postService->deletePost(post: $post);

        return response()->json([
            'success' => true
        ]);
    }
}
