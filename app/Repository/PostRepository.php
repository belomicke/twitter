<?php

namespace App\Repository;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PostRepository
{
    private function getPostCacheKey(int $id): string
    {
        return 'post:' . $id;
    }

    public function getPostById(int $id): Builder|Model|Post
    {
        $key = $this->getPostCacheKey(id: $id);

        return Cache::remember($key, 60, function () use ($id) {
            return Post::query()
                ->where('id', $id)
                ->where('is_deleted', false)
                ->first();
        });
    }

    public function incrementPostReplyCount(Post $post): Post
    {
        $post->reply_count += 1;
        $post->save();

        return $post;
    }

    public function incrementPostFavoriteCount(Post $post): Post
    {
        $post->favorite_count += 1;
        $post->save();

        return $post;
    }

    public function decrementPostFavoriteCount(Post $post): Post
    {
        $post->favorite_count -= 1;
        $post->save();

        return $post;
    }

    public function incrementPostRetweetCount(Post $post): Post
    {
        $post->retweet_count += 1;
        $post->save();

        return $post;
    }

    public function decrementPostRetweetCount(Post $post): Post
    {
        $post->retweet_count -= 1;
        $post->save();

        return $post;
    }

    public function checkIsQuoteExists(int $id, string $text): bool
    {
        return Post::query()
            ->where('user_id', Auth::id())
            ->where('retweeted_post_id', $id)
            ->where('text', $text)
            ->exists();
    }

    public function createPost(string $text): Post
    {
        $post = Post::create([
            'text' => $text,
            'user_id' => Auth::id()
        ]);
        $post->save();
        return $post->fresh();
    }

    public function createQuote(
        Post $post,
        string $text
    ): Post {
        $post = Post::create([
            'text' => $text,
            'retweeted_post_id' => $post->id,
            'is_quote' => true,
            'user_id' => Auth::id()
        ]);

        $post->save();
        return $post->fresh();
    }

    public function createReply(Post $post, string $text): ?Post
    {
        $post = Post::create([
            'text' => $text,
            'in_reply_to_post_id' => $post->id,
            'in_reply_to_user_id' => $post->user_id,
            'user_id' => Auth::id()
        ]);

        $post->save();
        return $post->fresh();
    }
}
