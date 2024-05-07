<?php

namespace App\Repository\Feed;

use App\Models\Post;
use App\Models\User;
use App\Repository\Account\ViewerRepository;
use App\Repository\Post\PinnedPostRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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
            ->orderByPivot('id', 'desc');

        if ($lastPostId !== 0) {
            $pivot = DB::table('liked_posts')
                ->where('post_id', $lastPostId)
                ->where('user_id', $user->id)
                ->first();

            $baseQuery = $baseQuery->wherePivot('id', '<', $pivot->id);
        }

        return [
            'items' => $baseQuery->take(50)->get(),
            'total' => $user->liked_posts_count
        ];
    }

    public function getBookmarkedPosts(int $lastPostId): array
    {
        $viewer = $this->viewerRepository->getViewer();

        $baseQuery = $viewer
            ->bookmarked_posts()
            ->orderBy('id', 'desc');

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '<', $lastPostId);
        }

        return [
            'items' => $baseQuery->take(50)->get(),
            'total' => $viewer->bookmarked_posts_count
        ];
    }

    public function getPostThread(Post $post, int $lastPostId): array
    {
        $baseQuery = $post
            ->descendants()
            ->where('is_deleted', false)
            ->orderBy('id');

        $total = $baseQuery->count();

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '>', $lastPostId);
        }

        return [
            'items' => $baseQuery->take(50)->get(),
            'total' => $total
        ];
    }

    public function getPostThreadHistory(Post $post, int $lastPostId): array
    {
        $baseQuery = $post
            ->ancestors()
            ->where('is_deleted', false)
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
