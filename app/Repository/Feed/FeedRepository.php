<?php

namespace App\Repository\Feed;

use App\Models\Post;
use App\Models\User;
use App\Repository\Account\ViewerRepository;
use App\Repository\Post\PinnedPostRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class FeedRepository
{
    public function __construct(
        private readonly ViewerRepository $viewerRepository,
        private readonly PinnedPostRepository $pinnedPostRepository
    ) {}

    public function getUserPosts(User $user, int $lastPostId): array
    {
        $baseQuery = $user
            ->posts()
            ->where('is_pinned', false)
            ->orderBy('id', 'desc');

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '<', $lastPostId);
        }

        if ($lastPostId === 0) {
            $pinnedPost = $this->pinnedPostRepository->getUserPinnedPost(user: $user);

            if ($pinnedPost) {
                $posts = $baseQuery->take(49)->get();
                $items = Collection::make([$pinnedPost, ...$posts]);
            } else {
                $items = $baseQuery->take(50)->get();
            }
        } else {
            $items = $baseQuery->take(50)->get();
        }

        return [
            'items' => $items,
            'total' => $user->posts_count
        ];
    }

    public function getUserLikedPosts(User $user, int $lastPostId): array
    {
        $baseQuery = $user
            ->liked_posts()
            ->where('posts.is_deleted', false)
            ->orderBy('id', 'desc');

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '<', $lastPostId);
        }

        return [
            'items' => $baseQuery->take(50)->get(),
            'total' => $user->liked_posts_count
        ];
    }

    public function getUserMediaPosts(User $user, int $lastPostId): array
    {
        $baseQuery = $user
            ->posts()
            ->where('media_count', '>', 0)
            ->orderBy('id', 'desc');

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '<', $lastPostId);
        }

        return [
            'items' => $baseQuery->take(50)->get(),
            'total' => $user->media_posts_count
        ];
    }

    public function getUserFavoritePosts(User $user, int $lastPostId): array
    {
        $baseQuery = $user
            ->favorite_posts()
            ->where('posts.is_deleted', false)
            ->orderByPivot('id', 'desc');

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '<', $lastPostId);
        }

        return [
            'items' => $baseQuery->take(50)->get(),
            'total' => $user->favorite_posts_count
        ];
    }

    public function getPostReplies(Post $post, int $lastPostId): array
    {
        $baseQuery = $post
            ->replies()
            ->where('posts.is_deleted', false)
            ->orderBy('id');

        $total = $post->reply_count;

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '>', $lastPostId);
        }

        return [
            'items' => $baseQuery->take(50)->get(),
            'total' => $total
        ];
    }

    public function getBookmarkedPosts(int $lastPostId): array
    {
        $viewer = $this->viewerRepository->getViewer();

        $baseQuery = $viewer
            ->bookmarked_posts()
            ->where('posts.is_deleted', false)
            ->orderBy('id', 'desc');

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '<', $lastPostId);
        }

        return [
            'items' => $baseQuery->take(50)->get(),
            'total' => $viewer->bookmarked_posts_count
        ];
    }

    public function getPostThreadHistory(Post $post, int $lastPostId): array
    {
        $baseQuery = $post
            ->ancestors()
            ->orderBy('id', 'desc');

        $total = $baseQuery->count();

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '<', $lastPostId);
        }

        return [
            'items' => $baseQuery->take(50)->get(),
            'total' => $total
        ];
    }

    public function getPostsByQuery(string $query, int $lastPostId): array
    {
        $baseQuery = Post::query()
            ->where('text', 'like', '%' . $query . '%')
            ->orWhereHas('author', function (Builder $builder) use ($query) {
                $builder->where('name', 'like', '%' . $query . '%')
                    ->orWhere('username', 'like', '%' . $query . '%');
            })
            ->where('is_deleted', false)
            ->whereNull('in_reply_to_post_id')
            ->orderBy('id', 'desc');

        $total = $baseQuery->count();

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '<', $lastPostId);
        }

        return [
            'items' => $baseQuery->take(50)->get(),
            'total' => $total
        ];
    }

    public function getFollowUsersPosts(int $lastPostId): array
    {
        $user = $this->viewerRepository->getViewer();

        $followIds = $user->follows()
            ->pluck('follow_id')
            ->toArray();
        $followIds[] = $user->id;

        $baseQuery = Post::query()
            ->whereIn('user_id', $followIds)
            ->where('is_deleted', false)
            ->whereNull('in_reply_to_post_id')
            ->orderBy('id', 'desc');

        $total = $baseQuery->count();

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '<', $lastPostId);
        }

        return [
            'items' => $baseQuery->take(50)->get(),
            'total' => $total
        ];
    }
}
