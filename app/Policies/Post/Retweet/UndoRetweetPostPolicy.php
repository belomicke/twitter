<?php

namespace App\Policies\Post\Retweet;

use App\Models\Post;
use App\Models\User;
use App\Repository\RetweetedPostRepository;

class UndoRetweetPostPolicy
{
    public function __construct(
        private readonly RetweetedPostRepository $retweetedPostRepository
    ) {}

    public function __invoke(User $user, Post $post): bool
    {
        return $this->retweetedPostRepository->exists(post: $post);
    }
}
