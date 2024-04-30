<?php

namespace App\Repository\Auth;

use App\Models\VerificationCode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VerificationCodeRepository
{
    public function getByEmail(string $email): Builder|Model|VerificationCode|null
    {
        return VerificationCode::query()
            ->where('email', $email)
            ->first();
    }

    public function create(string $email): string
    {
        $code = $this->generateVerificationCode();

        VerificationCode::create([
            'email' => $email,
            'code' => $code
        ]);

        return $code;
    }

    public function delete(string $email): void
    {
        VerificationCode::query()
            ->where('email', $email)
            ->delete();
    }

    public function checkCodeIsCorrect(string $email, string $code): bool
    {
        return VerificationCode::query()
            ->where('email', $email)
            ->where('code', $code)
            ->exists();
    }

    private function generateVerificationCode(): string
    {
        $result = '';

        for ($i = 0; $i < 6; $i++) {
            $result .= rand(0, 9);
        }

        return $result;
    }
}
