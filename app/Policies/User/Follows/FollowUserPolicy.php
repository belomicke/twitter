<?php

namespace App\Policies\User\Follows;

use App\Models\User;
use App\Repository\User\FollowRepository;

class FollowUserPolicy
{
    public function __construct(
        private readonly FollowRepository $followRepository
    ) {}

    public function __invoke(User $viewer, User $user): bool
    {
        if ($viewer->id === $user->id) {
            return false;
        }

        if ($this->followRepository->exists(user: $user)) {
            return false;
        }

        return true;
    }
}
