<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Services\Feed\FeedService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetFollowsPostsController extends Controller
{
    public function __construct(
        private readonly FeedService $feedService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $offset = $request->input('offset');
        $limit = $request->input('limit');

        $data = $this->feedService->getFollowsPosts(
            offset: $offset,
            limit: $limit
        );

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
