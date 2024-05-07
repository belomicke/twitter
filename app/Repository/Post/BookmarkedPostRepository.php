<?php

namespace App\Repository\Post;

use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookmarkedPostRepository
{
    public function bookmark(int $id): void
    {
        DB::table('bookmarked_posts')
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

    public function unbookmark(int $id): void
    {
        DB::table('bookmarked_posts')
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

        return DB::table('bookmarked_posts')
            ->where('user_id', Auth::id())
            ->where('post_id', $post->id)
            ->where('is_deleted', false)
            ->exists();
    }

    public function getStatus(int $id): bool
    {
        return DB::table('bookmarked_posts')
            ->where('user_id', Auth::id())
            ->where('is_deleted', false)
            ->where('post_id', $id)
            ->exists();
    }

    public function getMultipleStatuses(array $ids): Collection
    {
        return DB::table('bookmarked_posts')
            ->where('user_id', Auth::id())
            ->where('is_deleted', false)
            ->whereIn('post_id', $ids)
            ->get();
    }
}
