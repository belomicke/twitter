<?php

namespace App\Repository\Post;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class PostRepository
{
    public function getPostById(int $id): Builder|Model|Post|null
    {
        $post = Post::query()
            ->where('id', $id)
            ->where('is_deleted', false)
            ->first();

        if (!$post) {
            throw new ModelNotFoundException;
        }

        return $post;
    }

    public function getPostsByIds(array $ids): Collection
    {
        return Post::query()
            ->whereIn('id', $ids)
            ->where('is_deleted', false)
            ->get();
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

    public function createPost(
        string $text,
        int $mediaCount
    ): Post {
        $post = Post::create([
            'text' => $text,
            'user_id' => Auth::id(),
            'media_count' => $mediaCount
        ]);
        $post->save();
        return $post->fresh();
    }

    public function createQuote(
        Post $post,
        string $text,
        int $mediaCount
    ): Post {
        $post = Post::create([
            'text' => $text,
            'retweeted_post_id' => $post->id,
            'is_quote' => true,
            'user_id' => Auth::id(),
            'media_count' => $mediaCount
        ]);

        $post->save();
        return $post->fresh();
    }

    public function createReply(
        Post $post,
        string $text,
        int $mediaCount
    ): Post {
        $post = Post::create([
            'text' => $text,
            'in_reply_to_post_id' => $post->id,
            'in_reply_to_user_id' => $post->user_id,
            'user_id' => Auth::id(),
            'media_count' => $mediaCount
        ]);

        $post->save();
        return $post->fresh();
    }

    public function delete(Post $post): void
    {
        // delete all retweets
        Post::query()
            ->Where('retweeted_post_id', $post->id)
            ->where('text', '')
            ->update([
                'is_deleted' => true,
                'updated_at' => now()
            ]);

        // delete all replies
        $post
            ->descendants()
            ->update([
                'is_deleted' => true,
                'updated_at' => now()
            ]);

        // delete post
        $post
            ->update([
                'is_deleted' => true,
                'updated_at' => now()
            ]);
    }
}
