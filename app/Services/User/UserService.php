<?php

namespace App\Services\User;

use App\Models\User;
use App\Repository\Account\ViewerRepository;
use App\Repository\User\UserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct(
        private readonly ViewerRepository $viewerRepository,
        private readonly UserRepository $userRepository
    ) {}

    public function getUserById(int $id): User|Model|Builder|null
    {
        $viewer = $this->viewerRepository->getViewer();

        if ($viewer && $viewer->id === $id) {
            return $viewer;
        }

        return $this->userRepository->getUserById(id: $id);
    }

    public function getUserByUsername(string $username): User|Model|Builder|null
    {
        $viewer = $this->viewerRepository->getViewer();

        if ($viewer && $viewer->username === $username) {
            return $viewer;
        }

        return $this->userRepository->getUserByUsername(username: $username);
    }

    public function getUsersByIds(array $ids): Collection
    {
        if (count($ids) === 1) {
            if (array_values($ids)[0] === Auth::id()) {
                return Collection::make([Auth::user()]);
            }
        }

        return $this->userRepository->getUsersByIds(ids: $ids);
    }
}
