<?php

namespace Tests\Feature\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CreateAccountControllerTest extends TestCase
{
    use RefreshDatabase;

    const EXAMPLE_EMAIL = 'example@test.com';

    public function test_account_successfully_created(): void
    {
        $email = self::EXAMPLE_EMAIL;

        $this->postJson('/api/auth/send_verification_code', ['email' => $email]);

        $code = DB::table('verification_codes')->where('email', $email)->first()->code;

        $username = fake()->userName();

        $credentials = [
            'username' => $username,
            'password' => '12345678',
            'birth' => '2004-11-21',
            'email' => $email,
            'code' => $code
        ];

        $response = $this->postJson('/api/auth/create_account', $credentials);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'email' => $email,
            'username' => $username
        ]);
        $this->assertDatabaseCount('verification_codes', 0);
    }
}
