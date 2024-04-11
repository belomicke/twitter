<?php

namespace App\Services\Post;

use App\Exceptions\Quote\QuoteExistsException;
use App\Models\Post;
use App\Repository\FavoritePostRepository;
use App\Repository\PostRepository;
use App\Repository\RetweetedPostRepository;
use App\Repository\ViewerRepository;
use Illuminate\Support\Facades\Gate;

class PostService
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly FavoritePostRepository $favoritePostRepository,
        private readonly RetweetedPostRepository $retweetedPostRepository,
        private readonly ViewerRepository $viewerRepository
    ) {}

    public function createPost(string $text): Post
    {
        $post = $this->postRepository->createPost(
            text: $text,
        );

        $this->viewerRepository->incrementViewerPostCount();

        return $post;
    }

    /**
     * @throws QuoteExistsException
     */
    public function createQuote(
        Post $post,
        string $text
    ): Post {
        if (!Gate::allows('create-quote', [$post, $text])) {
            throw new QuoteExistsException;
        }

        $post = $this->postRepository->createQuote(
            post: $post,
            text: $text,
        );

        $this->viewerRepository->incrementViewerPostCount();

        return $post;
    }

    public function createReply(
        Post $post,
        string $text
    ): Post {
        $post = $this->postRepository->createReply(
            post: $post,
            text: $text,
        );

        $this->postRepository->incrementPostReplyCount(post: $post);

        return $post;
    }

    public function addPostToFavorite(Post $post): bool
    {
        $this->favoritePostRepository->add(id: $post->id);
        $this->postRepository->incrementPostFavoriteCount(post: $post);
        $this->viewerRepository->incrementViewerFavoritePostsCount();

        return true;
    }

    public function removePostFromFavorite(Post $post): bool
    {
        $this->favoritePostRepository->remove(id: $post->id);
        $this->postRepository->decrementPostFavoriteCount(post: $post);
        $this->viewerRepository->decrementViewerFavoritePostsCount();

        return true;
    }

    public function retweet(Post $post): Post
    {
        $retweet = $this->retweetedPostRepository->retweetPost(id: $post->id);
        $this->viewerRepository->incrementViewerPostCount();
        $this->postRepository->incrementPostRetweetCount(post: $post);

        return $retweet;
    }

    public function undoRetweet(Post $post): bool
    {
        $this->retweetedPostRepository->unretweetPost(id: $post->id);
        $this->viewerRepository->decrementViewerPostCount();
        $this->postRepository->decrementPostRetweetCount(post: $post);

        return true;
    }
}
