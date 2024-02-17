<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feed\FeedRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetUserPostsController extends Controller
{
    public function __invoke(FeedRequest $request, User $user): JsonResponse
    {
        $offset = $request->input('offset');
        $limit = $request->input('limit');

        $postsQuery = $user->posts()->orderBy('created_at', 'desc');

        $posts = $postsQuery->skip($offset)->take($limit)->get();
        $count = $postsQuery->count();
        $hasNextPage = $offset + $limit < $count;


        return response()->json([
            'success' => true,
            'data' => [
                'items' => $posts,
                'hasNextPage' => $hasNextPage,
                'total' => $count
            ]
        ]);
    }
}
