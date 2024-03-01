<?php

namespace App\Services\Feed;

use App\Models\Post;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FeedService
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function getUserPosts(string $username, int $lastPostId): array
    {
        $user = $this->userRepository->getUserByUsername($username);

        $postsQuery = $user
            ->posts()
            ->where('is_deleted', false)
            ->orderBy('id', 'desc');

        return $this->postHandler(
            postsQuery: $postsQuery,
            lastPostId: $lastPostId
        );
    }

    public function getFollowsPosts(int $lastPostId): array
    {
        $user = Auth::user();

        $followIds = $user
            ->follows()
            ->pluck('users.id');
        $followIds[] = $user->id;

        if ($lastPostId === 0) {
            $postsQuery = Post::query()
                ->whereIn('user_id', $followIds)
                ->orderBy('created_at', 'desc');
        } else {
            $postsQuery = Post::query()
                ->whereIn('user_id', $followIds)
                ->orderBy('created_at', 'desc')
                ->where('id', '<', $lastPostId);
        }

        return $this->postsWithUserHandler(
            postsQuery: $postsQuery,
        );
    }

    public function getUserLikedPosts(string $username, int $lastPostId): array
    {
        $user = $this->userRepository->getUserByUsername($username);

        if ($lastPostId === 0) {
            $postsQuery = $user
                ->liked_posts()
                ->wherePivot('is_deleted', false)
                ->orderByPivot('created_at', 'desc');
        } else {
            $pivot = DB::table('liked_posts')
                ->where('user_id', Auth::id())
                ->where('post_id', $lastPostId)
                ->first();

            $postsQuery = $user
                ->liked_posts()
                ->wherePivot('is_deleted', false)
                ->wherePivot('id', '<', $pivot->id)
                ->orderByPivot('created_at', 'desc');
        }

        return $this->postsWithUserHandler(
            postsQuery: $postsQuery
        );
    }

    private function postHandler(Builder|BelongsTo $postsQuery, int $lastPostId): array
    {
        $total = $postsQuery->count();

        if ($lastPostId !== 0) {
            $posts = $postsQuery
                ->where('id', '<', $lastPostId)
                ->take(50)
                ->get();
        } else {
            $posts = $postsQuery
                ->take(50)
                ->get();
        }

        return [
            'items' => $posts,
            'total' => $total
        ];
    }

    private function postsWithUserHandler(Builder|BelongsTo|BelongsToMany $postsQuery): array
    {
        $total = $postsQuery->count();

        $posts = $postsQuery
            ->take(50)
            ->get();

        $userIds = $posts->pluck('user_id');

        $users = User::query()
            ->whereIn('id', $userIds)
            ->get();

        $items = [];

        foreach ($posts as $post) {
            $items[] = [
                'post' => $post,
                'user' => $users
                    ->where('id', $post->user_id)
                    ->first()
            ];
        }

        return [
            'items' => $items,
            'total' => $total
        ];
    }
}
