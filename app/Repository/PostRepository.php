<?php

namespace App\Repository;

use App\Models\Post;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PostRepository
{
    private function getPostCacheKey(int $id): string
    {
        return 'post:'.$id;
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

    public function incrementPostReplyCount(int $id): Post
    {
        $key = $this->getPostCacheKey(id: $id);

        $post = $this->getPostById(id: $id);
        $post->reply_count += 1;
        $post->save();
        Cache::set($key, $post, 60);
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

    /**
     * @throws Exception
     */
    public function createPost(
        string $text,
        int|null $retweetedPostId,
        int|null $inReplyToPostId
    ): Post|bool {
        $formattedText = preg_replace("/\n+/", "\n\n", $text);
        $isQuote = $retweetedPostId !== null && strlen($formattedText) > 0;

        if ($isQuote) {
            $exists = $this->checkIsQuoteExists(
                id: $retweetedPostId,
                text: $formattedText
            );

            if ($exists) {
                throw new Exception('Вы уже писали об этом!');
            }
        }

        $inReplyToUserId = null;

        if ($inReplyToPostId !== null) {
            $inReplyToPost = $this->getPostById(id: $inReplyToPostId);
            $inReplyToUserId = $inReplyToPost->user_id;
        }

        $post = Post::create([
            'text' => $formattedText,
            'retweeted_post_id' => $retweetedPostId,
            'in_reply_to_post_id' => $inReplyToPostId,
            'in_reply_to_user_id' => $inReplyToUserId,
            'is_quote' => $isQuote,
            'user_id' => Auth::id()
        ]);
        $post->save();
        return $post->fresh();
    }
}
