<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Services\Feed\FeedService;
use Illuminate\Http\Request;

class GetBookmarkedPostsController extends Controller
{
    public function __construct(
        private readonly FeedService $feedService
    ) {}

    public function __invoke(Request $request)
    {
        $lastPostId = $request->input('last_post_id');

        $data = $this->feedService->getBookmarkedPosts(
            lastPostId: $lastPostId
        );

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
