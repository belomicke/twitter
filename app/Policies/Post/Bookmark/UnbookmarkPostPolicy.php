<?php

namespace App\Policies\Post\Bookmark;

use App\Models\Post;
use App\Models\User;
use App\Repository\Post\BookmarkedPostRepository;

class UnbookmarkPostPolicy
{
    public function __construct(
        private readonly BookmarkedPostRepository $bookmarkedPostRepository
    ) {}

    public function __invoke(User $user, Post $post): bool
    {
        return $this->bookmarkedPostRepository->exists(post: $post);
    }
}
