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
        $formattedText = preg_replace("/\n+/", "\n\n", $text);

        $post = Post::create([
            'text' => $formattedText,
            'user_id' => Auth::id()
        ]);
        $post->save();

        return response()->json([
            'success' => true,
            'data' => [
                'post' => $post
            ]
        ]);
    }
}
