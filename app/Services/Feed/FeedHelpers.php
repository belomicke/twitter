<?php

namespace App\Services\Feed;

use App\Models\Post;
use App\Models\User;
use App\Repository\UserRepository;

class FeedHelpers
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function commentsToJson($posts): array
    {
        $userIds = $posts->pluck('user_id');
        $users = User::query()
            ->whereIn('id', $userIds)
            ->get();

        $items = [];

        foreach ($posts as $post) {
            $user = $users
                ->where('id', $post->user_id)
                ->first();

            $items[] = $this->getPostJson(
                post: $post,
                user: $user,
                retweetedPost: null,
                retweetedPostUser: null,
            );
        }

        return $items;
    }

    public function postsToJson($posts): array
    {
        $userIds = $posts->pluck('user_id');
        $retweetsIds = $posts->pluck('retweeted_post_id');

        $users = User::query()
            ->whereIn('id', $userIds)
            ->get();

        $retweetedPosts = Post::query()
            ->whereIn('id', $retweetsIds)
            ->where('is_deleted', false)
            ->get();

        $retweetedPostsAuthorsIds = $retweetedPosts->pluck('user_id');

        $retweetedPostsAuthors = User::query()
            ->whereIn('id', $retweetedPostsAuthorsIds)
            ->get();

        $items = [];

        foreach ($posts as $post) {
            $user = $users
                ->where('id', $post->user_id)
                ->first();

            $retweetedPost = $retweetedPosts
                ->where('id', $post->retweeted_post_id)
                ->first();

            if ($retweetedPost) {
                $retweetedPostsUser = $retweetedPostsAuthors
                    ->where('id', $retweetedPost->user_id)
                    ->first();
            } else {
                $retweetedPostsUser = null;
            }

            $items[] = $this->getPostJson(
                post: $post,
                user: $user,
                retweetedPost: $retweetedPost,
                retweetedPostUser: $retweetedPostsUser,
            );
        }

        return $items;
    }

    private function getPostJson(
        Post $post,
        User $user,
        Post|null $retweetedPost,
        User|null $retweetedPostUser
    ): array {
        $post->in_reply_to_username = null;

        if ($post->in_reply_to_user_id) {
            $user = $this->userRepository->getUserById(id: $post->in_reply_to_user_id);
            $post->in_reply_to_username = $user->username;
        }

        $item = [
            'post' => $post,
            'extensions' => [
                'retweeted_post' => null
            ],
            'user' => $user
        ];

        if ($retweetedPost) {
            $item['extensions']['retweeted_post']['post'] = $retweetedPost;
            $item['extensions']['retweeted_post']['user'] = $retweetedPostUser;
        }

        return $item;
    }
}
