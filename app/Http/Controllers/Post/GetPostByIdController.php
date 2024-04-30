<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Repository\Post\PostRepository;
use App\Services\Post\PostHelpers;
use Illuminate\Http\JsonResponse;

class GetPostByIdController extends Controller
{
    public function __construct(
        private readonly PostHelpers $postHelpers,
        private readonly PostRepository $postRepository,
    ) {}

    public function __invoke(int $id): JsonResponse
    {
        $post = $this->postRepository->getPostById(id: $id);
        $data = $this->postHelpers->postToJson(post: $post);

        return response()->json(data: [
            'success' => true,
            'data' => $data
        ]);
    }
}
