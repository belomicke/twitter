<?php

namespace App\Services\Post;

use App\Exceptions\Quote\QuoteExistsException;
use App\Models\Post;
use App\Repository\Account\ViewerRepository;
use App\Repository\Media\MediaRepository;
use App\Repository\Post\BookmarkedPostRepository;
use App\Repository\Post\LikedPostRepository;
use App\Repository\Post\PinnedPostRepository;
use App\Repository\Post\PostRepository;
use App\Repository\Post\RetweetedPostRepository;
use Illuminate\Support\Facades\Gate;

class PostService
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly LikedPostRepository $likedPostRepository,
        private readonly RetweetedPostRepository $retweetedPostRepository,
        private readonly ViewerRepository $viewerRepository,
        private readonly MediaRepository $mediaRepository,
        private readonly PinnedPostRepository $pinnedPostRepository,
        private readonly BookmarkedPostRepository $bookmarkedPostRepository
    ) {}

    public function createPost(string $text, array|null $media): Post
    {
        $post = $this->postRepository->createPost(
            text: $text,
            mediaCount: $media ? count($media) : 0
        );

        $this->viewerRepository->incrementViewerPostCount();

        if ($media) {
            $this->mediaRepository->saveImages(
                postId: $post->id,
                files: $media
            );
        }

        return $post;
    }

    /**
     * @throws QuoteExistsException
     */
    public function createQuote(
        Post $post,
        string $text,
        array|null $media
    ): Post {
        if (!Gate::allows('create-quote', [$post, $text])) {
            throw new QuoteExistsException;
        }

        $post = $this->postRepository->createQuote(
            post: $post,
            text: $text,
            mediaCount: $media ? count($media) : 0
        );

        $this->viewerRepository->incrementViewerPostCount();

        if ($media) {
            $this->mediaRepository->saveImages(
                postId: $post->id,
                files: $media
            );
        }

        return $post;
    }

    public function createReply(
        Post $post,
        string $text,
        array|null $media
    ): Post {
        $reply = $this->postRepository->createReply(
            post: $post,
            text: $text,
            mediaCount: $media ? count($media) : 0
        );

        $this->postRepository->incrementPostReplyCount(post: $post);

        if ($media) {
            $this->mediaRepository->saveImages(
                postId: $reply->id,
                files: $media
            );
        }

        return $reply;
    }

    public function likePost(Post $post): bool
    {
        $this->likedPostRepository->like(id: $post->id);
        $this->postRepository->incrementPostLikeCount(post: $post);
        $this->viewerRepository->incrementViewerLikedPostsCount();

        return true;
    }

    public function unlikePost(Post $post): bool
    {
        $this->likedPostRepository->unlike(id: $post->id);
        $this->postRepository->decrementPostLikeCount(post: $post);
        $this->viewerRepository->decrementViewerLikedPostsCount();

        return true;
    }

    public function bookmarkPost(Post $post): bool
    {
        $this->bookmarkedPostRepository->bookmark(id: $post->id);

        return true;
    }

    public function unbookmarkPost(Post $post): bool
    {
        $this->bookmarkedPostRepository->unbookmark(id: $post->id);

        return true;
    }

    public function retweet(Post $post): Post
    {
        $retweet = $this->retweetedPostRepository->retweetPost(id: $post->id);
        $this->viewerRepository->incrementViewerPostCount(count: 1);
        $this->postRepository->incrementPostRetweetCount(post: $post);

        return $retweet;
    }

    public function undoRetweet(Post $post): bool
    {
        $this->retweetedPostRepository->unretweetPost(id: $post->id);
        $this->viewerRepository->decrementViewerPostCount(count: 1);
        $this->postRepository->decrementPostRetweetCount(post: $post);

        return true;
    }

    public function pinPost(Post $post): void
    {
        $viewer = $this->viewerRepository->getViewer();

        $this->pinnedPostRepository->unpinUserPost(user: $viewer);
        $this->pinnedPostRepository->pinPost(post: $post);
    }

    public function unpinPost(Post $post): void
    {
        $this->pinnedPostRepository->unpinPost(post: $post);
    }

    public function deletePost(Post $post): void
    {
        if ($this->retweetedPostRepository->exists(post: $post)) {
            $this->viewerRepository->decrementViewerPostCount(count: 2);
        } else {
            $this->viewerRepository->decrementViewerPostCount(count: 1);
        }
        $this->postRepository->delete(post: $post);
    }
}
