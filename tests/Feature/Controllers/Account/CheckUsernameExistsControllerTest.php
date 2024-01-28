<?php

namespace Tests\Feature\Controllers\Account;

use App\Models\User;
use Tests\TestCase;

class CheckUsernameExistsControllerTest extends TestCase
{
    public function test_when_user_exists(): void
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/account/username_exists?username={$user->username}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.exists', true);
    }

    public function test_when_user_not_exists(): void
    {
        $username = fake()->userName();

        $response = $this->getJson("/api/account/username_exists?username={$username}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.exists', false);
    }

    public function test_when_provided_username_is_too_short(): void
    {
        $username = 'usr';

        $response = $this->getJson("/api/account/username_exists?username={$username}");

        $response->assertStatus(422);
    }

    public function test_when_provided_username_is_too_long(): void
    {
        $username = 'very long username which contains more than 32 symbols';

        $response = $this->getJson("/api/account/username_exists?username={$username}");

        $response->assertStatus(422);
    }

    public function test_when_username_is_not_provided(): void
    {
        $response = $this->getJson("/api/account/username_exists");

        $response->assertStatus(422);
    }
}
