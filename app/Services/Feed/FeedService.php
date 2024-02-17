<?php

namespace App\Services\Feed;

use App\Repository\UserRepository;


class FeedService
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function getUserPosts (string $username, int $offset, int $limit): array
    {
        $user = $this->userRepository->getUserByUsername($username);

        $postsQuery = $user->posts()->orderBy('created_at', 'desc');

        $posts = $postsQuery->skip($offset)->take($limit)->get();
        $count = $postsQuery->count();
        $hasNextPage = $offset + $limit < $count;

        return [
            'items' => $posts,
            'hasNextPage' => $hasNextPage,
            'count' => $count
        ];
    }
}
