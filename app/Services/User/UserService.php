<?php

namespace App\Services\User;

use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function create(
        string $username,
        string $email,
        string $password,
        string $birth
    ): User|null {
        return User::create([
            'name' => $username,
            'username' => $username,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'birth' => $birth
        ]);
    }

    public function edit(
        int $id,
        string $name,
        string|null $bio,
        string|null $location,
        string|null $link
    ): Model|Builder|null {
        $user = $this->userRepository->getUserById($id);

        $user->name = $name;
        $user->bio = $bio ?? '';
        $user->location = $location ?? '';
        $user->link = $link ?? '';

        return $user;
    }
}
