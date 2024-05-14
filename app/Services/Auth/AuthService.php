<?php

namespace App\Services\Auth;

use App\Exceptions\User\IncorrectCredentialsException;
use App\Exceptions\User\IncorrectVerificationCodeException;
use App\Jobs\VerificationCodeEmailJob;
use App\Repository\Auth\VerificationCodeRepository;
use App\Repository\User\UserRepository;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly VerificationCodeRepository $verificationCodeRepository
    ) {}

    public function sendVerificationCode(string $email): void
    {
        $entity = $this->verificationCodeRepository->getByEmail(email: $email);

        if ($entity) {
            $code = $entity->code;
        } else {
            $code = $this->verificationCodeRepository->create(email: $email);
        }

        VerificationCodeEmailJob::dispatch(
            email: $email,
            code: $code
        );
    }

    /**
     * @throws IncorrectCredentialsException
     */
    public function createAccessToken(string $username, string $password): string
    {
        $user = $this->userRepository->getUserByUsername($username);

        if (!$user) {
            throw new IncorrectCredentialsException();
        }

        $passwordIsCorrect = $user->checkPassword(password: $password);

        if (!$passwordIsCorrect) {
            throw new IncorrectCredentialsException();
        }

        $credentials = [
            'username' => $username,
            'password' => $password
        ];

        Auth::attempt($credentials, true);

        $user->tokens()->delete();

        return $user->createToken('token')->plainTextToken;
    }

    /**
     * @throws IncorrectVerificationCodeException
     */
    public function createAccount(
        string $username,
        string $email,
        string $password,
        string $birth,
        string $code
    ): void {
        $codeIsCorrect = $this->verificationCodeRepository->checkCodeIsCorrect(
            email: $email,
            code: $code
        );

        if (!$codeIsCorrect) {
            throw new IncorrectVerificationCodeException();
        }

        $this->userRepository->create(
            username: $username,
            email: $email,
            password: $password,
            birth: $birth
        );

        $this->verificationCodeRepository->delete(email: $email);
    }

    public function deleteAllAccessTokens(): void
    {
        Auth::guard('sanctum')->user()->tokens()->delete();
    }
}
