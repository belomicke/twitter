<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    public function getUserByUsername(string $username): User|Model|Builder|null
    {
        return User::query()->where('username', $username)->first();
    }

    public function getUserByEmail(string $email): User|Model|Builder|null
    {
        return User::query()->where('email', $email)->first();
    }

    public function checkUserWithEmailExists(string $email): bool
    {
        return User::query()->where('email', $email)->exists();
    }

    public function checkUserWithUsernameExists(string $username): bool
    {
        return User::query()->where('username', $username)->exists();
    }
}
