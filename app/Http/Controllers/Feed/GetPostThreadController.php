<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feed\FeedRequest;
use App\Models\Post;
use App\Services\Feed\FeedService;
use Illuminate\Http\JsonResponse;

class GetPostThreadController extends Controller
{
    public function __construct(
        private readonly FeedService $feedService
    ) {}

    public function __invoke(FeedRequest $request, Post $post): JsonResponse
    {
        $lastPostId = $request->input('last_post_id');

        $data = $this->feedService->getPostThread(
            post: $post,
            lastPostId: $lastPostId
        );

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
