<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CreatePostController extends Controller
{
    public function __invoke(CreatePostRequest $request): JsonResponse
    {
        $text = $request->input('text');
        $retweetedPostId = $request->input('retweeted_post_id') ?? null;
        $formattedText = preg_replace("/\n+/", "\n\n", $text);

        if ($retweetedPostId !== null) {
            $retweetExists = Post::query()
                ->where('user_id', Auth::id())
                ->where('retweeted_post_id', $retweetedPostId)
                ->where('text', $text)
                ->exists();

            if ($retweetExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Вы уже писали об этом'
                ], 500);
            }
        }

        $user = Auth::user();

        $post = Post::create([
            'text' => $formattedText,
            'retweeted_post_id' => $retweetedPostId,
            'user_id' => $user->id
        ]);
        $post->save();

        $user->posts_count += 1;
        $user->save();

        return response()->json([
            'success' => true,
            'data' => [
                'post' => $post->fresh()
            ]
        ]);
    }
}
