<?php

namespace App\Repository\Post;

class LikedPostRepository extends PostUserRelationRepository
{
    protected string $table = 'liked_posts';
}
