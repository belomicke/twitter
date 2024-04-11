<?php

namespace App\Policies\Post\Favorite;

use App\Models\Post;
use App\Models\User;
use App\Repository\FavoritePostRepository;

class AddPostToFavoritePolicy
{
    public function __construct(
        private readonly FavoritePostRepository $favoritePostRepository
    ) {}

    public function __invoke(User $user, Post $post): bool
    {
        return !$this->favoritePostRepository->exists(post: $post);
    }
}