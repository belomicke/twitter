<?php

namespace App\Services\Feed;

use App\Models\Post;
use App\Models\User;
use App\Repository\Feed\FeedRepository;
use App\Services\Post\PostHelpers;

class FeedService
{
    public function __construct(
        private readonly PostHelpers $postHelpers,
        private readonly FeedRepository $feedRepository,
    ) {}

    public function getUserPosts(User $user, int $lastPostId): array
    {
        $result = $this->feedRepository->getUserPosts(
            user: $user,
            lastPostId: $lastPostId
        );

        return [
            'items' => $this->postHelpers->postsToJson($result['items']),
            'total' => $result['total']
        ];
    }

    public function getUserFavoritedPosts(User $user, int $lastPostId): array
    {
        $result = $this->feedRepository->getUserFavoritedPosts(
            user: $user,
            lastPostId: $lastPostId
        );

        return [
            'items' => $this->postHelpers->postsToJson($result['items']),
            'total' => $result['total']
        ];
    }

    public function getPostReplies(Post $post, int $lastPostId): array
    {
        $result = $this->feedRepository->getPostReplies(
            post: $post,
            lastPostId: $lastPostId
        );

        return [
            'items' => $this->postHelpers->postsToJson($result['items']),
            'total' => $result['total']
        ];
    }

    public function getPostThread(Post $post, int $lastPostId): array
    {
        $result = $this->feedRepository->getPostThread(
            post: $post,
            lastPostId: $lastPostId
        );

        return [
            'items' => $this->postHelpers->postsToJson($result['items']),
            'total' => $result['total']
        ];
    }

    public function getPostThreadHistory(Post $post, int $lastPostId): array
    {
        $result = $this->feedRepository->getPostThreadHistory(
            post: $post,
            lastPostId: $lastPostId
        );

        return [
            'items' => $this->postHelpers->commentsToJson($result['items']),
            'total' => $result['total']
        ];
    }

    public function getFollowsPosts(int $lastPostId): array
    {
        $result = $this->feedRepository->getFollowUsersPosts(lastPostId: $lastPostId);

        return [
            'items' => $this->postHelpers->postsToJson($result['items']),
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
            'items' => $this->postHelpers->postsToJson($result['items']),
            'total' => $result['total']
        ];
    }
}
