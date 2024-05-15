<?php

namespace App\Http\Controllers\Post;

use App\Exceptions\Quote\QuoteExistsException;
use App\Helpers\PostHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreateQuoteRequest;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class CreateQuoteController extends Controller
{
    public function __construct(
        private readonly PostHelpers $postHelpers,
        private readonly PostService $postService
    ) {}

    /**
     * @throws QuoteExistsException
     */
    public function __invoke(CreateQuoteRequest $request, Post $post): JsonResponse
    {
        if ($post->is_deleted) {
            throw new ModelNotFoundException();
        }

        $text = $request->input('text') ?? '';
        $files = $request->allFiles() ?? [];

        if (!Gate::allows('create-quote', [$post->id, $text])) {
            throw new QuoteExistsException();
        }

        $quote = $this->postService->createQuote(
            postId: $post->id,
            text: $text,
            media: $files['media'] ?? null
        );

        return response()->json([
            'success' => true,
            'data' => $this->postHelpers->postToJson(
                post: $quote,
                freshPost: true,
                retweetedPost: $post
            )
        ]);
    }
}
