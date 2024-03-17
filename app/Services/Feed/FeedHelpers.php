<?php

namespace App\Services\Feed;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FeedHelpers
{
    public function postHandler(Builder|BelongsTo|BelongsToMany $postsQuery, int $lastPostId): array
    {
        $total = $postsQuery->count();
        $postFromBuilder = $this->getPostsFromBuilder(
            postsQuery: $postsQuery,
            lastPostId: $lastPostId
        );

        $posts = $postFromBuilder['posts'];
        $users = $postFromBuilder['users'];
        $retweetedPosts = $postFromBuilder['retweeted_posts'];
        $retweetedPostsUsers = $postFromBuilder['retweeted_posts_users'];

        $items = [];

        foreach ($posts as $post) {
            $user = $users
                ->where('id', $post->user_id)
                ->first();

            $retweetedPost = $retweetedPosts
                ->where('id', $post->retweeted_post_id)
                ->first();

            if ($retweetedPost) {
                $retweetedPostsUser = $retweetedPostsUsers
                    ->where('id', $retweetedPost->user_id)
                    ->first();
            } else {
                $retweetedPostsUser = null;
            }

            $items[] = $this->getPostJson(
                post: $post,
                user: $user,
                retweetedPost: $retweetedPost,
                retweetedPostUser: $retweetedPostsUser
            );
        }

        return [
            'items' => $items,
            'total' => $total
        ];
    }

    private function getPostsFromBuilder(Builder|BelongsTo|BelongsToMany $postsQuery, int $lastPostId): array
    {
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

        $userIds = $posts->pluck('user_id');

        $users = User::query()
            ->whereIn('id', $userIds)
            ->get();

        $retweetsIds = $posts->pluck('retweeted_post_id');

        $retweetedPosts = Post::query()
            ->whereIn('id', $retweetsIds)
            ->where('is_deleted', false)
            ->get();

        $retweetedPostsAuthorsIds = $retweetedPosts->pluck('user_id');

        $retweetedPostsAuthors = User::query()
            ->whereIn('id', $retweetedPostsAuthorsIds)
            ->get();

        return [
            'posts' => $posts,
            'users' => $users,
            'retweeted_posts' => $retweetedPosts,
            'retweeted_posts_users' => $retweetedPostsAuthors
        ];
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
                retweetedPostUser: $retweetedPostsUser
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
        $item = [
            'post' => $post,
            'extensions' => [
                'retweet' => null
            ],
            'user' => $user
        ];

        if ($retweetedPost) {
            $item['extensions']['retweet']['post'] = $retweetedPost;
            $item['extensions']['retweet']['user'] = $retweetedPostUser;
        }

        return $item;
    }
}
