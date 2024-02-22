<?php

namespace App\Services\Feed;

use App\Models\Post;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;


class FeedService
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function getUserPosts(string $username, int $offset, int $limit): array
    {
        $user = $this->userRepository->getUserByUsername($username);

        $postsQuery = $user->posts()->orderBy('created_at', 'desc');

        $posts = $postsQuery->skip($offset)->take($limit)->get();
        $total = $postsQuery->count();
        $hasNextPage = $offset + $limit < $total;

        return [
            'items' => $posts,
            'hasNextPage' => $hasNextPage,
            'total' => $total
        ];
    }

    public function getFollowsPosts(int $offset, int $limit): array
    {
        $user = Auth::user();

        $followIds = $user->follows()->pluck('users.id');
        $followIds[] = $user->id;

        $postsQuery = Post::query()
            ->whereIn('user_id', $followIds)
            ->orderBy('created_at', 'desc');

        $posts = $postsQuery->skip($offset)->take($limit)->get();
        $total = $postsQuery->count();
        $hasNextPage = $offset + $limit < $total;

        $userIds = $posts->pluck('user_id');

        $users = User::query()->whereIn('id', $userIds)->get();

        $items = [];

        foreach ($posts as $post) {
            $items[] = [
                'post' => $post,
                'user' => $users->where('id', $post->user_id)->first()
            ];
        }

        return [
            'items' => $items,
            'hasNextPage' => $hasNextPage,
            'total' => $total
        ];
    }
}
