<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateAccessTokenControllerTest extends TestCase
{
    use RefreshDatabase;

    const CREATE_ACCESS_TOKEN_URL = '/api/auth/create_access_token';
    const CURRENT_USER_URL = '/api/account/current_user';

    public function test_created_token_is_correct(): void
    {
        $user = User::factory()->create();

        $credentials = [
            'username' => $user->username,
            'password' => '12345678'
        ];

        $tokenResponse = $this->postJson(self::CREATE_ACCESS_TOKEN_URL, $credentials);
        $token = $tokenResponse->json()['data']['token'];

        $response = $this
            ->withHeader('authenticated', $token)
            ->getJson(self::CURRENT_USER_URL);

        $response->assertJsonPath('data.user.id', $user->id);
        $response->assertStatus(200);
    }

    public function test_status_422_when_credentials_are_not_provided(): void
    {
        $response = $this->postJson(self::CREATE_ACCESS_TOKEN_URL);

        $response->assertStatus(422);
    }

    public function test_status_422_when_username_is_not_provided(): void
    {
        $credentials = [
            'password' => '12345678'
        ];

        $response = $this->postJson(self::CREATE_ACCESS_TOKEN_URL, $credentials);

        $response->assertStatus(422);
    }

    public function test_status_422_when_username_is_not_exists(): void
    {
        $credentials = [
            'username' => 'not existed username',
            'password' => '12345678'
        ];

        $response = $this->postJson(self::CREATE_ACCESS_TOKEN_URL, $credentials);

        $response->assertStatus(422);
    }

    public function test_status_422_when_username_is_too_short(): void
    {
        $credentials = [
            'username' => 'usr',
            'password' => '12345678'
        ];

        $response = $this->postJson(self::CREATE_ACCESS_TOKEN_URL, $credentials);

        $response->assertStatus(422);
    }

    public function test_status_422_when_username_is_too_long(): void
    {
        $credentials = [
            'username' => 'ThisIsUsernameWhichContainsMoreThan32Symbols',
            'password' => '12345678'
        ];

        $response = $this->postJson(self::CREATE_ACCESS_TOKEN_URL, $credentials);

        $response->assertStatus(422);
    }

    public function test_status_422_when_password_is_not_provided(): void
    {
        $user = User::factory()->create();

        $credentials = [
            'username' => $user->username,
        ];

        $response = $this->postJson(self::CREATE_ACCESS_TOKEN_URL, $credentials);

        $response->assertStatus(422);
    }

    public function test_status_422_when_password_is_too_short(): void
    {
        $user = User::factory()->create();

        $credentials = [
            'username' => $user->username,
            'password' => '1234'
        ];

        $response = $this->postJson(self::CREATE_ACCESS_TOKEN_URL, $credentials);

        $response->assertStatus(422);
    }

    public function test_status_422_when_password_is_incorrect(): void
    {
        $user = User::factory()->create();

        $credentials = [
            'username' => $user->username,
            'password' => '123456789'
        ];

        $response = $this->postJson(self::CREATE_ACCESS_TOKEN_URL, $credentials);

        $response->assertStatus(422);
    }
}
