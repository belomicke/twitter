<?php

namespace App\Repository;

use App\Models\Post;
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
        return $retweet;
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
}
