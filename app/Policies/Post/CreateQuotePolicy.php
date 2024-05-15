<?php

namespace App\Policies\Post;

use App\Helpers\PostHelpers;
use App\Models\User;
use App\Repository\Post\PostRepository;

class CreateQuotePolicy
{
    public function __construct(
        private readonly PostRepository $postRepository
    ) {}

    public function __invoke(User $user, int $postId, string $text): bool
    {
        $text = PostHelpers::formatText(text: $text);

        return !$this->postRepository->getQuoteExistsStatus(
            id: $postId,
            text: $text
        );
    }
}
