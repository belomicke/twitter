<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Repository\Account\ViewerRepository;
use App\Repository\Media\MediaRepository;
use App\Repository\Post\BookmarkedPostRepository;
use App\Repository\Post\FavoritePostRepository;
use App\Repository\Post\LikedPostRepository;
use App\Repository\Post\PinnedPostRepository;
use App\Repository\Post\PostRepository;
use App\Repository\Post\RetweetedPostRepository;

class PostService
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly LikedPostRepository $likedPostRepository,
        private readonly RetweetedPostRepository $retweetedPostRepository,
        private readonly ViewerRepository $viewerRepository,
        private readonly MediaRepository $mediaRepository,
        private readonly PinnedPostRepository $pinnedPostRepository,
        private readonly BookmarkedPostRepository $bookmarkedPostRepository,
        private readonly FavoritePostRepository $favoritePostRepository
    ) {}

    public function createPost(string $text, array|null $media): Post
    {
        $viewer = $this->viewerRepository->getViewer();

        $post = $this->postRepository->createPost(
            text: $text,
            mediaCount: $media ? count($media) : 0
        );

        if ($media) {
            $viewer->media_count += count($media);
            $viewer->media_posts_count++;

            $this->mediaRepository->saveImages(
                postId: $post->id,
                files: $media
            );
        }

        $viewer->posts_count++;
        $viewer->save();

        return $post;
    }

    public function createQuote(
        int $postId,
        string $text,
        array|null $media
    ): Post {
        $viewer = $this->viewerRepository->getViewer();

        $post = $this->postRepository->createPost(
            text: $text,
            mediaCount: $media ? count($media) : 0,
            retweetedPostId: $postId,
        );

        if ($media) {
            $viewer->media_count += count($media);
            $viewer->media_posts_count++;

            $this->mediaRepository->saveImages(
                postId: $post->id,
                files: $media
            );
        }

        $viewer->posts_count++;
        $viewer->save();

        return $post;
    }

    public function createReply(
        Post $post,
        string $text,
        array|null $media
    ): Post {
        $viewer = $this->viewerRepository->getViewer();

        $reply = $this->postRepository->createPost(
            text: $text,
            mediaCount: $media ? count($media) : 0,
            inReplyToPost: $post
        );

        $this->postRepository->incrementPostReplyCount(post: $post);

        if ($media) {
            $viewer->media_count++;
            $viewer->media_posts_count += count($media);
            $viewer->save();

            $this->mediaRepository->saveImages(
                postId: $reply->id,
                files: $media
            );
        }

        return $reply;
    }

    public function likePost(Post $post): void
    {
        $this->likedPostRepository->add(id: $post->id);
        $this->postRepository->incrementPostLikeCount(post: $post);
        $this->viewerRepository->incrementViewerLikedPostsCount();
    }

    public function unlikePost(Post $post): void
    {
        $this->likedPostRepository->remove(id: $post->id);
        $this->postRepository->decrementPostLikeCount(post: $post);
        $this->viewerRepository->decrementViewerLikedPostsCount();
    }

    public function bookmarkPost(Post $post): void
    {
        $this->bookmarkedPostRepository->add(id: $post->id);
    }

    public function unbookmarkPost(Post $post): void
    {
        $this->bookmarkedPostRepository->remove(id: $post->id);
    }

    public function retweet(Post $post): Post
    {
        $retweet = $this->retweetedPostRepository->retweetPost(id: $post->id);
        $this->viewerRepository->incrementViewerPostCount();
        $this->postRepository->incrementPostRetweetCount(post: $post);

        return $retweet;
    }

    public function undoRetweet(Post $post): void
    {
        $this->retweetedPostRepository->undoRetweetPost(id: $post->id);
        $this->viewerRepository->decrementViewerPostCount();
        $this->postRepository->decrementPostRetweetCount(post: $post);
    }

    public function addPostToFavoriteList(Post $post): void
    {
        $this->favoritePostRepository->add(id: $post->id);
        $this->viewerRepository->incrementViewerFavoritePostsCount();
        $post->is_favorite = true;
        $post->save();
    }

    public function removePostFromFavoriteList(Post $post): void
    {
        $this->favoritePostRepository->remove(id: $post->id);
        $this->viewerRepository->decrementViewerFavoritePostsCount();
        $post->is_favorite = false;
        $post->save();
    }

    public function pinPost(Post $post): void
    {
        $this->pinnedPostRepository->unpinViewerPost();
        $this->pinnedPostRepository->pinPost(post: $post);
    }

    public function unpinPost(Post $post): void
    {
        $this->pinnedPostRepository->unpinPost(post: $post);
    }

    public function deletePost(Post $post): void
    {
        $this->postRepository->delete(post: $post);
    }
}
