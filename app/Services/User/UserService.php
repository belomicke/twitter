<?php

namespace App\Services\User;

use App\Models\User;
use App\Repository\Account\ViewerRepository;
use App\Repository\User\UserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    public function __construct(
        private readonly ViewerRepository $viewerRepository,
        private readonly UserRepository $userRepository
    ) {}

    public function getUserByUsername(string $username): User|Model|Builder|null
    {
        $viewer = $this->viewerRepository->getViewer();

        if ($viewer && $viewer->username === $username) {
            return $viewer;
        }

        return $this->userRepository->getUserByUsername(username: $username);
    }
}
