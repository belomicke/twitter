<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Services\Feed\FeedService;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetUserMediaPostsFeedController extends Controller
{
    public function __construct(
        private readonly FeedService $feedService,
        private readonly UserService $userService
    ) {}

    public function __invoke(Request $request, string $username): JsonResponse
    {
        $lastPostId = $request->input('last_post_id');

        $user = $this->userService->getUserByUsername(username: $username);

        $data = $this->feedService->getUserMediaPosts(
            user: $user,
            lastPostId: $lastPostId
        );

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
