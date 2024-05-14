<?php

namespace App\Policies\Post;

use App\Models\User;
use App\Repository\Post\PostRepository;
use App\Services\Post\PostHelpers;

class CreateQuotePolicy
{
    public function __construct(
        private readonly PostRepository $postRepository
    ) {}

    public function __invoke(User $user, int $postId, string $text): bool
    {
        $text = PostHelpers::formatText(text: $text);

        return !$this->postRepository->checkIsQuoteExists(
            id: $postId,
            text: $text
        );
    }
}
