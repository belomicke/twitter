<?php

namespace App\Repository;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoritePostRepository
{
    public function add(int $id): void
    {
        DB::table('favorited_posts')
            ->where('post_id', $id)
            ->where('user_id', Auth::id())
            ->updateOrInsert([
                'post_id' => $id,
                'user_id' => Auth::id(),
                'is_deleted' => false,
                'updated_at' => now(),
                'created_at' => now()
            ]);
    }

    public function remove(int $id): void
    {
        DB::table('favorited_posts')
            ->where('post_id', $id)
            ->where('user_id', Auth::id())
            ->where('is_deleted', false)
            ->update([
                'is_deleted' => true,
                'updated_at' => now()
            ]);
    }

    public function exists(Post $post): bool
    {
        if ($post->is_deleted) {
            return false;
        }

        return DB::table('favorited_posts')
            ->where('user_id', Auth::id())
            ->where('post_id', $post->id)
            ->where('is_deleted', false)
            ->exists();
    }
}
