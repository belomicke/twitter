<?php

namespace App\Policies\Post;

use App\Models\Post;
use App\Models\User;

class UnlikePostPolicy
{
    public function unlike(User $user, Post $post): bool
    {
        return $post->likers->contains($user->id);
    }
}
