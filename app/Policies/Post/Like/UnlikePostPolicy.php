<?php

namespace App\Policies\Post\Like;

use App\Models\Post;
use App\Models\User;
use App\Repository\Post\LikedPostRepository;

class UnlikePostPolicy
{
    public function __construct(
        private readonly LikedPostRepository $likedPostRepository
    ) {}

    public function __invoke(User $user, Post $post): bool
    {
        return $this->likedPostRepository->getStatus(post: $post);
    }
}
