<?php

namespace App\Policies\Post;

use App\Models\Post;
use App\Models\User;

class EditPostPolicy
{
    public function __invoke(User $user, Post $post): bool
    {
        return $post->user_id === $user->id;
    }
}
