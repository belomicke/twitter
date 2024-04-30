<?php

namespace App\Http\Controllers\Post;

use App\Exceptions\Quote\QuoteExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreateQuoteRequest;
use App\Models\Post;
use App\Services\Post\PostHelpers;
use App\Services\Post\PostService;
use Illuminate\Http\JsonResponse;

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
        $text = $request->input('text') ?? '';
        $files = $request->allFiles() ?? [];

        $post = $this->postService->createQuote(
            post: $post,
            text: $text,
            media: $files['media'] ?? null
        );

        return response()->json([
            'success' => true,
            'data' => $this->postHelpers->postToJson(post: $post)
        ]);
    }
}
