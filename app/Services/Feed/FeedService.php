<?php

namespace App\Services\Feed;

use App\Models\User;
use App\Repository\FeedRepository;

class FeedService
{
    public function __construct(
        private readonly FeedRepository $feedRepository,
        private readonly FeedHelpers $feedHelpers
    ) {}

    public function getUserPosts(User $user, int $lastPostId): array
    {
        $result = $this->feedRepository->getUserPosts(
            user: $user,
            lastPostId: $lastPostId
        );

        return [
            'items' => $this->feedHelpers->postsToJson($result['posts']),
            'total' => $result['total']
        ];
    }

    public function getFollowsPosts(int $lastPostId): array
    {
        $result = $this->feedRepository->getFollowUsersPosts(lastPostId: $lastPostId);

        return [
            'items' => $this->feedHelpers->postsToJson($result['posts']),
            'total' => $result['total']
        ];
    }

    public function getUserLikedPosts(User $user, int $lastPostId): array
    {
        $result = $this->feedRepository->getUserLikedPosts(
            user: $user,
            lastPostId: $lastPostId
        );

        return [
            'items' => $this->feedHelpers->postsToJson($result['posts']),
            'total' => $result['total']
        ];
    }

    public function getPostsByQuery(string $query, int $lastPostId): array
    {
        $result = $this->feedRepository->getPostsByQuery(
            query: $query,
            lastPostId: $lastPostId
        );

        return [
            'items' => $this->feedHelpers->postsToJson($result['posts']),
            'total' => $result['total']
        ];
    }
}
