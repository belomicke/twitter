<?php

namespace App\Policies\Post;

use App\Models\Post;
use App\Models\User;

class LikePostPolicy
{
    public function like(User $user, Post $post): bool
    {
        $allow = false;

        if (!$post->likers->contains($user->id)) {
            if ($post->text !== '') {
                $allow = true;
            }
        }

        return $allow;
    }
}
