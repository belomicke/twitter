<?php

namespace App\Services\Post;

use App\Helpers\ArrayHelpers;
use App\Helpers\CollectionHelpers;
use App\Models\Post;
use App\Models\User;
use App\Repository\Account\ViewerRepository;
use App\Repository\Media\MediaRepository;
use App\Repository\Post\LikedPostRepository;
use App\Repository\Post\PostRepository;
use App\Repository\Post\RetweetedPostRepository;
use App\Repository\User\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class PostHelpers
{
    public function __construct(
        private readonly ViewerRepository $viewerRepository,
        private readonly UserRepository $userRepository,
        private readonly PostRepository $postRepository,
        private readonly MediaRepository $mediaRepository,
        private readonly LikedPostRepository $likedPostRepository,
        private readonly RetweetedPostRepository $retweetedPostRepository
    ) {}

    public static function formatText(string $text): string
    {
        return preg_replace("/\n+/", "\n\n", $text);
    }

    public function commentsToJson(Collection $posts): array
    {
        if ($posts->count() === 0) {
            return [];
        }

        $postsIds = CollectionHelpers::getSetFromCollection($posts->pluck('id'));
        $authorsIds = CollectionHelpers::getSetFromCollection($posts->pluck('user_id'));
        $authors = $this->userRepository->getUsersByIds(ids: $authorsIds);

        $retweetedStatuses = $this->retweetedPostRepository->getMultipleStatuses(ids: $postsIds);
        $likedStatuses = $this->likedPostRepository->getMultipleStatuses(ids: $postsIds);

        $items = [];

        $media = $this->mediaRepository->getMediaByPostIds(ids: $postsIds);

        $inReplyToUserIds = CollectionHelpers::getSetFromCollection($posts->pluck('in_reply_to_user_id'));

        if (count($inReplyToUserIds)) {
            $inReplyToUsers = $this->userRepository->getUsersByIds(ids: $inReplyToUserIds);
        } else {
            $inReplyToUsers = Collection::make();
        }

        foreach ($posts as $post) {
            $retweeted = $retweetedStatuses->where('retweeted_post_id', $post->id)->first() !== null;
            $liked = $likedStatuses->where('post_id', $post->id)->first() !== null;

            $post->liked = $liked;
            $post->retweeted = $retweeted;

            if ($post->in_reply_to_user_id) {
                $inReplyToUsername = $inReplyToUsers->where('id', $post->in_reply_to_user_id)->first()->username;
                $post->in_reply_to_username = $inReplyToUsername;
            }

            $author = $authors
                ->where('id', $post->user_id)
                ->first();

            $items[] = $this->getPostJson(
                post: $post,
                user: $author,
                media: $media->where('post_id', $post->id),
                retweetedPost: null,
                retweetedPostUser: null,
                retweetedPostMedia: null
            );
        }

        return $items;
    }

    public function postsToJson(Collection $posts): array
    {
        if ($posts->count() === 0) {
            return [];
        }

        $postIds = CollectionHelpers::getSetFromCollection(
            collection: $posts->pluck('id')
        );

        // Получаем id ретвитнутых постов
        $retweetsIds = CollectionHelpers::getSetFromCollection(
            collection: $posts->pluck('retweeted_post_id')
        );
        // Удаляем все null из массива
        $retweetsIds = ArrayHelpers::removeNullsFromArray(array: $retweetsIds);

        // Получаем ретвитнутые посты, не включая те, которые могли быть удалены
        $retweetedPosts = $this->postRepository->getPostsByIds(ids: $retweetsIds);

        // Получаем id только тех ретвитнутых постов, которые не удалены
        $retweetsIds = CollectionHelpers::getSetFromCollection(
            collection: $retweetedPosts->pluck('id')
        );

        // Получаем id всех публикаций (и постов, и ретвитов)
        $allPostIds = array_unique([...$postIds, ...$retweetsIds]);

        // Получаем все медиа(картинки) которые испульзуются во всех публикациях
        $media = $this->mediaRepository->getMediaByPostIds(ids: $allPostIds);

        // Получаем id всех авторов (и постов, и ретвитов)
        $userIds = CollectionHelpers::getSetFromCollection(
            collection: $posts->pluck('user_id')
        );
        $retweetedPostsUserIds = CollectionHelpers::getSetFromCollection(
            collection: $retweetedPosts->pluck('user_id')
        );
        $allUsersIds = array_unique([...$userIds, ...$retweetedPostsUserIds]);

        // Получаем всех авторов
        $users = $this->userRepository->getUsersByIds(ids: $allUsersIds);

        $likedStatuses = $this->likedPostRepository->getMultipleStatuses(ids: $allPostIds);
        $retweetedStatuses = $this->retweetedPostRepository->getMultipleStatuses(ids: $allPostIds);

        $items = [];

        foreach ($posts as $post) {
            $retweeted = $retweetedStatuses->where('retweeted_post_id', $post->id)->first() !== null;
            $liked = $likedStatuses->where('post_id', $post->id)->first() !== null;

            $post->retweeted = $retweeted;
            $post->liked = $liked;

            $user = $users
                ->where('id', $post->user_id)
                ->first();

            $retweet = null;
            $retweetUser = null;
            $retweetMedia = null;

            if ($post->retweeted_post_id) {
                $retweet = $retweetedPosts
                    ->where('id', $post->retweeted_post_id)
                    ->first();

                if ($retweet) {
                    $retweeted = $retweetedStatuses->where('retweeted_post_id', $retweet->id)->first() !== null;
                    $retweet->retweeted = $retweeted;

                    $liked = $likedStatuses->where('post_id', $retweet->id)->first() !== null;
                    $retweet->liked = $liked;

                    $retweetUser = $users
                        ->where('id', $retweet->user_id)
                        ->first();

                    if ($retweet->media_count) {
                        $retweetMedia = $media->whereIn('post_id', $retweet->id);
                    }
                }
            }

            $items[] = $this->getPostJson(
                post: $post,
                user: $user,
                media: $media->whereIn('post_id', $post->id),
                retweetedPost: $retweet,
                retweetedPostUser: $retweetUser,
                retweetedPostMedia: $retweetMedia
            );
        }

        return $items;
    }

    public function postToJson(Post $post): array
    {
        $viewer = $this->viewerRepository->getViewer();

        if ($post->user_id === $viewer->id) {
            $author = $viewer;
        } else {
            $author = $this->userRepository->getUserById(id: $post->user_id);
        }

        $liked = $this->likedPostRepository->getStatus(id: $post->id);
        $retweeted = $this->retweetedPostRepository->getStatus(id: $post->id);

        $post->liked = $liked;
        $post->retweeted = $retweeted;

        $item = $this->getPostInJson(
            post: $post,
            user: $author
        );

        if ($post->media_count > 0) {
            $media = $this->mediaRepository->getPostMedia(id: $post->id);

            $item['extensions']['media'] = $media;
        }

        if ($post->retweeted_post_id) {
            $retweetedPost = $this->postRepository->getPostById(id: $post->retweeted_post_id);
            $retweetedPostUser = $this->userRepository->getUserById(id: $retweetedPost->user_id);
            $retweetedPostMedia = $this->mediaRepository->getPostMedia(id: $retweetedPost->id);

            $retweetedPostJson = $this->getPostInJson(
                post: $retweetedPost,
                user: $retweetedPostUser
            );

            $item['extensions']['media'] = $retweetedPostMedia;
            $item['extensions']['retweeted_post'] = $retweetedPostJson;
        }

        return $item;
    }

    private function getPostJson(
        Post $post,
        User $user,
        Collection|null $media,
        Post|null $retweetedPost,
        User|null $retweetedPostUser,
        Collection|null $retweetedPostMedia
    ): array {
        $item = [
            'post' => $post->toArray(),
            'user' => $user->toArray(),
            'extensions' => [
                'retweeted_post' => null,
                'media' => null
            ]
        ];

        if ($retweetedPost) {
            $item['extensions']['retweeted_post']['post'] = $retweetedPost->toArray();
            $item['extensions']['retweeted_post']['user'] = $retweetedPostUser->toArray();
            $item['extensions']['retweeted_post']['extensions']['media'] = $retweetedPostMedia;
            $item['extensions']['retweeted_post']['extensions']['retweeted_post'] = null;
        }

        if ($media && $media->count()) {
            $item['extensions']['media'] = [...$media->toArray()];
        } else {
            $item['extensions']['media'] = null;
        }

        return $item;
    }

    public function getPostInJson(
        Post $post,
        User $user,
    ): array {
        return [
            'post' => $post->toArray(),
            'user' => $user->toArray(),
            'extensions' => [
                'retweeted_post' => null,
                'media' => null
            ]
        ];
    }
}
