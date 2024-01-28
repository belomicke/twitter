<?php

namespace App\Services\VerificationCode;

class VerificationCodeService
{
    public static function generateVerificationCode(): int
    {
        $result = '';

        for ($i = 0; $i < 6; $i++) {
            $result .= rand(0, 9);
        }

        return (int)$result;
    }
}
