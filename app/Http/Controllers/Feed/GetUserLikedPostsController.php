<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feed\FeedRequest;
use App\Repository\User\UserRepository;
use App\Services\Feed\FeedService;
use Illuminate\Http\JsonResponse;

class GetUserLikedPostsController extends Controller
{
    public function __construct(
        private readonly FeedService $feedService,
        private readonly UserRepository $userRepository
    ) {}

    public function __invoke(FeedRequest $request, string $username): JsonResponse
    {
        $lastPostId = $request->input('last_post_id');

        $user = $this->userRepository->getUserByUsername(username: $username);

        $data = $this->feedService->getUserLikedPosts(
            user: $user,
            lastPostId: $lastPostId
        );

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
