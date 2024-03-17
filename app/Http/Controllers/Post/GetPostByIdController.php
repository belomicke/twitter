<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Feed\FeedHelpers;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class GetPostByIdController extends Controller
{
    public function __construct(
        private readonly FeedHelpers $feedHelpers
    ) {}

    public function __invoke(Post $post): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->feedHelpers->postsToJson(Collection::make([$post]))[0]
        ]);
    }
}
