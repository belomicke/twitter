<?php

namespace App\Repository\User;

use App\Models\User;
use App\Repository\Account\ViewerRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function __construct(
        private readonly ViewerRepository $viewerRepository
    ) {}

    public function getUserById(int $id): User|Model|Builder|null
    {
        $viewer = $this->viewerRepository->getViewer();

        if ($viewer && $viewer->id === $id) {
            return $viewer;
        }

        return User::query()->where('id', $id)->first();
    }

    public function getUserByUsername(string $username): User|Model|Builder|null
    {
        $viewer = $this->viewerRepository->getViewer();

        if ($viewer && $viewer->username === $username) {
            return $viewer;
        }

        return User::query()->where('username', $username)->first();
    }

    public function getUsersByIds(array $ids): Collection
    {
        if (count($ids) === 1) {
            return Collection::make(items: [$this->getUserById(id: $ids[0])]);
        }

        return User::query()->whereIn('id', $ids)->get();
    }

    public function searchUserByQuery(string $query): Collection
    {
        return User::search($query)->take(20)->get();
    }

    public function checkUserWithEmailExists(string $email): bool
    {
        return User::query()->where('email', $email)->exists();
    }

    public function checkUserWithUsernameExists(string $username): bool
    {
        return User::query()->where('username', $username)->exists();
    }

    public function create(
        string $username,
        string $email,
        string $password,
        string $birth
    ): User|null {
        $user = User::create(attributes: [
            'name' => $username,
            'username' => $username,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make(value: $password),
            'birth' => $birth
        ]);
        $user->save();

        return $user->fresh();
    }

    public function incrementFollowersCount(int $id): void
    {
        User::query()->where('id', $id)->increment('followers_count');
    }

    public function decrementFollowersCount(int $id): void
    {
        User::query()->where('id', $id)->decrement('followers_count');
    }

    public function incrementFollowsCount(int $id): void
    {
        User::query()->where('id', $id)->increment('follows_count');
    }

    public function decrementFollowsCount(int $id): void
    {
        User::query()->where('id', $id)->decrement('follows_count');
    }
}
