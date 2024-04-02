<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Repository\PostRepository;
use App\Services\Feed\FeedHelpers;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class GetPostByIdController extends Controller
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly FeedHelpers $feedHelpers
    ) {}

    public function __invoke(int $id): JsonResponse
    {
        $post = $this->postRepository->getPostById(id: $id);

        return response()->json([
            'success' => true,
            'data' => $this->feedHelpers->postsToJson(Collection::make([$post]))[0]
        ]);
    }
}
