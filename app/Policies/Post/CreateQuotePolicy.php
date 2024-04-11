<?php

namespace App\Policies\Post;

use App\Helpers\PostHelpers;
use App\Models\Post;
use App\Models\User;
use App\Repository\PostRepository;

class CreateQuotePolicy
{
    public function __construct(
        private readonly PostRepository $postRepository
    ) {}

    public function __invoke(User $user, Post $post, string $text): bool
    {
        $text = PostHelpers::formatText(text: $text);

        return !$this->postRepository->checkIsQuoteExists(
            id: $post->id,
            text: $text
        );
    }
}
