<?php

namespace App\Repository\Post;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class RetweetedPostRepository
{
    public function retweetPost(int $id): Post
    {
        return Post::create([
            'text' => '',
            'retweeted_post_id' => $id,
            'user_id' => Auth::id()
        ])
            ->fresh();
    }

    public function undoRetweetPost(int $id): void
    {
        Post::query()
            ->where('user_id', Auth::id())
            ->where('retweeted_post_id', $id)
            ->where('text', '')
            ->where('is_deleted', false)
            ->update([
                'is_deleted' => true
            ]);
    }

    public function getStatus(Post $post): bool
    {
        return Post::query()
            ->where('retweeted_post_id', $post->id)
            ->where('user_id', Auth::id())
            ->where('text', '')
            ->where('is_deleted', false)
            ->exists();
    }

    public function getStatusById(int $id): bool
    {
        return Post::query()
            ->where('retweeted_post_id', $id)
            ->where('user_id', Auth::id())
            ->where('text', '')
            ->where('is_deleted', false)
            ->exists();
    }

    public function getMultipleStatuses(array $ids): Collection
    {
        return Post::query()
            ->whereIn('retweeted_post_id', $ids)
            ->where('user_id', Auth::id())
            ->where('text', '')
            ->where('is_deleted', false)
            ->get();
    }
}
