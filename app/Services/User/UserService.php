<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(string $username, string $email, string $password, string $birth): User|null
    {
        return User::create([
            'name' => $username,
            'username' => $username,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'birth' => $birth
        ]);
    }
}
