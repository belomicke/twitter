<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feed\FeedRequest;
use App\Models\User;
use App\Services\Feed\FeedService;
use Illuminate\Http\JsonResponse;

class GetUserLikedPostsController extends Controller
{
    public function __construct(
        private readonly FeedService $feedService
    ) {}

    public function __invoke(FeedRequest $request, User $user): JsonResponse
    {
        $lastPostId = $request->input('last_post_id');

        $data = $this->feedService->getUserLikedPosts(
            username: $user->username,
            lastPostId: $lastPostId
        );

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
