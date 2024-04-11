<?php

namespace App\Http\Controllers\Post\Retweet;

use App\Exceptions\Post\Retweet\PostIsNotRetweetedAlreadyException;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class UndoRetweetPostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    /**
     * @throws PostIsNotRetweetedAlreadyException
     */
    public function __invoke(Post $post): JsonResponse
    {
        if (!Gate::allows('undo-retweet-post', $post)) {
            throw new PostIsNotRetweetedAlreadyException;
        }

        $result = $this->postService->undoRetweet($post);

        return response()->json([
            'success' => $result
        ]);
    }
}
