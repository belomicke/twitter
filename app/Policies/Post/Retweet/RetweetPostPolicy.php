<?php

namespace App\Policies\Post\Retweet;

use App\Models\Post;
use App\Models\User;
use App\Repository\Post\RetweetedPostRepository;

class RetweetPostPolicy
{
    public function __construct(
        private readonly RetweetedPostRepository $retweetedPostRepository
    ) {}

    public function __invoke(User $user, Post $post): bool
    {
        return !$this->retweetedPostRepository->getStatus(post: $post);
    }
}
