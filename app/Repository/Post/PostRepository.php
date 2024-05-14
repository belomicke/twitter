<?php

namespace App\Repository\Post;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostRepository
{
    public function getPostById(int $id): Builder|Model|Post
    {
        $post = Post::query()
            ->where('id', $id)
            ->where('is_deleted', false)
            ->first();

        if ($post === null) {
            throw new ModelNotFoundException();
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

    public function incrementPostLikeCount(Post $post): Post
    {
        $post->like_count += 1;
        $post->save();

        return $post;
    }

    public function decrementPostLikeCount(Post $post): Post
    {
        $post->like_count -= 1;
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
        int $mediaCount,
        int $retweetedPostId = null,
        Post $inReplyToPost = null
    ): Post {
        return Post::create([
            'text' => $text,
            'retweeted_post_id' => $retweetedPostId,
            'is_quote' => $retweetedPostId !== null,
            'in_reply_to_post_id' => $inReplyToPost?->id,
            'in_reply_to_user_id' => $inReplyToPost?->user_id,
            'user_id' => Auth::id(),
            'media_count' => $mediaCount
        ])->fresh();
    }

    public function delete(Post $post): void
    {
        $viewer = Auth::user();

        // delete all retweets
        if ($post->retweet_count !== 0) {
            $post->retweeters()->decrement('posts_count');

            Post::query()
                ->where('retweeted_post_id', $post->id)
                ->where('text', '')
                ->update([
                    'is_deleted' => true,
                    'updated_at' => now()
                ]);
        }

        // delete all likes
        if ($post->like_count !== 0) {
            $post->likers()->decrement('liked_posts_count');

            DB::table('liked_posts')
                ->where('post_id', $post->id)
                ->update([
                    'is_deleted' => true
                ]);
        }

        // decrement all media counters
        if ($post->media_count !== 0) {
            $viewer->media_count -= $post->media_count;
            $viewer->media_posts_count--;
        }

        // decrement viewer post count if post was retweeted by viewer
        $isRetweeted = Post::query()
            ->where('retweeted_post_id', $post->id)
            ->where('user_id', $viewer->id)
            ->where('text', '')
            ->exists();

        if ($isRetweeted) {
            $viewer->posts_count--;
        }

        // decrement favorite posts count
        if ($post->is_favorite) {
            $viewer->favorite_posts_count--;
        }

        $viewer->posts_count--;
        $viewer->save();

        // delete post
        $post
            ->update([
                'is_pinned' => false,
                'is_favorite' => false,
                'is_deleted' => true,
                'updated_at' => now()
            ]);
    }
}
