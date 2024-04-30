<?php

namespace App\Repository\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PinnedPostRepository
{
    public function getUserPinnedPost(User $user): Post|Model|BelongsTo|null
    {
        return $user
            ->posts()
            ->where('is_pinned', true)
            ->first();
    }

    public function pinPost(Post $post): void
    {
        $post->is_pinned = true;
        $post->save();
    }

    public function unpinPost(Post $post): void
    {
        $post->is_pinned = false;
        $post->save();
    }

    public function unpinUserPost(User $user): void
    {
        Post::query()
            ->where('user_id', $user->id)
            ->where('is_pinned', true)
            ->update([
                'is_pinned' => false
            ]);
    }
}
