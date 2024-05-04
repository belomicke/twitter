<?php

namespace App\Repository\Post;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class RetweetedPostRepository
{
    public function retweetPost(int $id): Post
    {
        $retweet = Post::create([
            'text' => '',
            'retweeted_post_id' => $id,
            'user_id' => Auth::id()
        ]);

        $retweet->save();
        return $retweet->fresh();
    }

    public function unretweetPost(int $id): void
    {
        $retweet = Post::query()
            ->where('user_id', Auth::id())
            ->where('retweeted_post_id', $id)
            ->where('text', '')
            ->where('is_deleted', false)
            ->first();
        $retweet->is_deleted = true;
        $retweet->save();
    }

    public function exists(Post $post): bool
    {
        if ($post->is_deleted) {
            return false;
        }

        return Post::query()
            ->where('retweeted_post_id', $post->id)
            ->where('user_id', Auth::id())
            ->where('text', '')
            ->where('is_deleted', false)
            ->exists();
    }

    public function getStatus(int $id): bool
    {
        return Post::query()
            ->where('user_id', Auth::id())
            ->where('is_deleted', false)
            ->where('text', '')
            ->where('retweeted_post_id', $id)
            ->exists();
    }

    public function getMultipleStatuses(array $ids): Collection
    {
        return Post::query()
            ->where('user_id', Auth::id())
            ->where('is_deleted', false)
            ->where('text', '')
            ->whereIn('retweeted_post_id', $ids)
            ->get();
    }
}
