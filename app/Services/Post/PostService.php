<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Repository\FavoritePostRepository;
use App\Repository\PostRepository;
use App\Repository\RetweetedPostRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly FavoritePostRepository $favoritePostRepository,
        private readonly RetweetedPostRepository $retweetedPostRepository
    ) {}

    /**
     * @throws Exception
     */
    public function createPost(
        string $text,
        int|null $retweetedPostId,
        int|null $inReplyToPostId
    ): Post {
        $post = $this->postRepository->createPost(
            text: $text,
            retweetedPostId: $retweetedPostId,
            inReplyToPostId: $inReplyToPostId
        );

        if ($inReplyToPostId === null) {
            $user = Auth::user();
            $user->posts_count += 1;
            $user->save();
        }

        if ($inReplyToPostId !== null) {
            $this->incrementCommentsCount(id: $inReplyToPostId);
        }

        return $post;
    }

    public function like(Post $post): bool
    {
        $viewer = Auth::user();

        $this->favoritePostRepository->favoritePost(id: $post->id);
        $post->favorite_count += 1;
        $post->save();

        $viewer->favourites_count += 1;
        $viewer->save();

        return true;
    }

    public function unlike(Post $post): bool
    {
        $viewer = Auth::user();

        $this->favoritePostRepository->unfavoritePost(id: $post->id);
        $post->favorite_count -= 1;
        $post->save();

        $viewer->favourites_count -= 1;
        $viewer->save();

        return true;
    }

    public function retweet(Post $post): Post
    {
        $viewer = Auth::user();

        $retweet = $this->retweetedPostRepository->retweetPost(id: $post->id);

        $post->retweet_count += 1;
        $post->save();

        $viewer->posts_count += 1;
        $viewer->save();

        return $retweet;
    }

    public function undoRetweet(Post $post): bool
    {
        $viewer = Auth::user();

        $this->retweetedPostRepository->unretweetPost(id: $post->id);

        $post->retweet_count -= 1;
        $post->save();

        $viewer->posts_count -= 1;
        $viewer->save();

        return true;
    }

    public function incrementCommentsCount(int $id): void
    {
        $this->postRepository->incrementPostReplyCount(id: $id);
    }
}
