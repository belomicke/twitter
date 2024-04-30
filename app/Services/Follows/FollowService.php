<?php

namespace App\Services\Follows;

use App\Models\User;
use App\Repository\User\FollowRepository;
use App\Repository\User\UserRepository;
use Illuminate\Support\Facades\Auth;

class FollowService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly FollowRepository $followRepository,
    ) {}

    public function follow(User $user): void
    {
        $this->followRepository->follow(user: $user);
        $this->userRepository->incrementFollowsCount(Auth::id());
        $this->userRepository->incrementFollowersCount(id: $user->id);
    }

    public function unfollow(User $user): void
    {
        $this->followRepository->unfollow(user: $user);
        $this->userRepository->decrementFollowsCount(Auth::id());
        $this->userRepository->decrementFollowersCount(id: $user->id);
    }
}
