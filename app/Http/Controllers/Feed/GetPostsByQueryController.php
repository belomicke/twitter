<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Services\Feed\FeedService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetPostsByQueryController extends Controller
{
    public function __construct(
        private readonly FeedService $feedService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $query = $request->input('query');
        $lastPostId = $request->input('last_post_id');

        $data = $this->feedService->getPostsByQuery(
            query: $query,
            lastPostId: $lastPostId
        );

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
