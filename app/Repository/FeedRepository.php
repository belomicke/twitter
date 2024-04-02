<?php

namespace App\Repository;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeedRepository
{
    public function getUserPosts(User $user, int $lastPostId): array
    {
        $baseQuery = Post::query()
            ->where('user_id', $user->id)
            ->where('is_deleted', false)
            ->whereNull('in_reply_to_post_id')
            ->orderBy('id', 'desc');

        $total = $baseQuery->count();

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '<', $lastPostId);
        }

        return [
            'posts' => $baseQuery->take(50)->get(),
            'total' => $total
        ];
    }

    public function getPostComments(Post $post, int $lastPostId): array
    {
        $baseQuery = Post::query()
            ->where('in_reply_to_post_id', $post->id)
            ->where('is_deleted', false)
            ->orderBy('id', 'desc');

        $total = $baseQuery->count();

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '<', $lastPostId);
        }

        return [
            'posts' => $baseQuery->take(50)->get(),
            'total' => $total
        ];
    }

    public function getPostThread(Post $post, int $lastPostId): array
    {
        $baseQuery = $post->descendants()
            ->where('is_deleted', false)
            ->orderBy('id');

        $total = $baseQuery->count();

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '>', $lastPostId);
        }

        return [
            'posts' => $baseQuery->take(50)->get(),
            'total' => $total
        ];
    }

    public function getPostThreadHistory(Post $post, int $lastPostId): array
    {
        $baseQuery = $post->ancestors()
            ->where('is_deleted', false)
            ->orderBy('id', 'desc');

        $total = $baseQuery->count();

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '<', $lastPostId);
        }

        return [
            'posts' => $baseQuery->take(50)->get()->reverse(),
            'total' => $total
        ];
    }

    public function getPostsByQuery(string $query, int $lastPostId): array
    {
        $baseQuery = Post::query()
            ->where('text', 'like', '%'.$query.'%')
            ->orWhereHas('author', function (Builder $builder) use ($query) {
                $builder->where('name', 'like', '%'.$query.'%')
                    ->orWhere('username', 'like', '%'.$query.'%');
            })
            ->where('is_deleted', false)
            ->whereNull('in_reply_to_post_id')
            ->orderBy('id', 'desc');

        $total = $baseQuery->count();

        if ($lastPostId !== 0) {
            $baseQuery = $baseQuery->where('id', '<', $lastPostId);
        }

        return [
            'posts' => $baseQuery->take(50)->get(),
            'total' => $total
        ];
    }

    public function getFollowUsersPosts(int $lastPostId): array
    {
        $user = Auth::user();

        $followIds = $user
            ->follows()
            ->pluck('users.id');
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
            'posts' => $baseQuery->take(50)->get(),
            'total' => $total
        ];
    }

    public function getUserLikedPosts(User $user, int $lastPostId): array
    {
        $baseQuery = $user
            ->favorited_posts()
            ->wherePivot('is_deleted', false)
            ->orderByPivot('id', 'desc');

        $total = $baseQuery->count();

        if ($lastPostId !== 0) {
            $pivot = DB::table('favorited_posts')
                ->where('post_id', $lastPostId)
                ->where('user_id', $user->id)
                ->first();

            $baseQuery = $baseQuery->wherePivot('id', '<', $pivot->id);
        }

        return [
            'posts' => $baseQuery->take(50)->get(),
            'total' => $total
        ];
    }
}
