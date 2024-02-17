<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feed\FeedRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class GetYourFollowingsPostsController extends Controller
{
    public function __invoke(FeedRequest $request): JsonResponse
    {
        $offset = $request->input('offset');
        $limit = $request->input('limit');

        $posts = Post::query()
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get();
        $userIds = $posts->pluck('user_id')->unique();
        $users = User::query()->whereIn('id', $userIds)->get();

        $items = [];

        foreach ($posts as $post) {
            $items[] = [
                'post' => $post,
                'user' => $users->where('id', $post->user_id)->first()
            ];
        }

        $count = Post::query()->count();
        $hasNextPage = $offset + $limit < $count;

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $items,
                'hasNextPage' => $hasNextPage,
                'total' => $count
            ]
        ]);
    }
}
