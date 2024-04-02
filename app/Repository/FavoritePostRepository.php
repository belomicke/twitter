<?php

namespace App\Repository;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoritePostRepository
{
    public function favoritePost(int $id): void
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

    public function unfavoritePost(int $id): void
    {
        DB::table('favorited_posts')
            ->where('post_id', $id)
            ->where('user_id', Auth::id())
            ->update([
                'is_deleted' => true,
                'updated_at' => now()
            ]);
    }
}
