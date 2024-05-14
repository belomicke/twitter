<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feed\FeedRequest;
use App\Services\Feed\FeedService;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;

class GetUserPostsController extends Controller
{
    public function __construct(
        private readonly FeedService $feedService,
        private readonly UserService $userService
    ) {}

    public function __invoke(FeedRequest $request, string $username): JsonResponse
    {
        $lastPostId = $request->input('last_post_id');

        $user = $this->userService->getUserByUsername(username: $username);

        $data = $this->feedService->getUserPosts(
            user: $user,
            lastPostId: $lastPostId
        );

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
