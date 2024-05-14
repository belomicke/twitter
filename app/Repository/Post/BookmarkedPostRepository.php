<?php

namespace App\Repository\Post;

class BookmarkedPostRepository extends PostUserRelationRepository
{
    protected string $table = 'bookmarked_posts';
}
