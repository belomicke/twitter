<?php

namespace App\Http\Controllers\Post\Like;

use App\Exceptions\Post\Like\PostIsLikedAlreadyException;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class LikePostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    /**
     * @throws PostIsLikedAlreadyException
     */
    public function __invoke(Post $post): JsonResponse
    {
        if ($post->is_deleted) {
            throw new ModelNotFoundException();
        }

        if (!Gate::allows('like-post', $post)) {
            throw new PostIsLikedAlreadyException();
        }

        $this->postService->likePost(post: $post);

        return response()->json([
            'success' => true
        ]);
    }
}
