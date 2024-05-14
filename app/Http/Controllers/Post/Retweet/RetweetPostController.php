<?php

namespace App\Http\Controllers\Post\Retweet;

use App\Exceptions\Post\Retweet\PostIsRetweetedAlreadyException;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class RetweetPostController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
    ) {}

    /**
     * @throws PostIsRetweetedAlreadyException
     */
    public function __invoke(Post $post): JsonResponse
    {
        if ($post->is_deleted) {
            throw new ModelNotFoundException();
        }

        if (!Gate::allows('retweet-post', $post)) {
            throw new PostIsRetweetedAlreadyException();
        }

        $retweet = $this->postService->retweet($post);

        return response()->json([
            'success' => true,
            'data' => [
                'post' => $retweet
            ]
        ]);
    }
}
