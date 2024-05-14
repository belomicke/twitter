<?php

namespace App\Repository\Post;

class FavoritePostRepository extends PostUserRelationRepository
{
    protected string $table = 'favorite_posts';
}
