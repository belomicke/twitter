<?php

namespace Tests\Feature\Controllers\Account;

use App\Models\User;
use Tests\TestCase;

class CheckEmailExistsControllerTest extends TestCase
{
    public function test_when_user_exists(): void
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/account/email_exists?email={$user->email}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.exists', true);
    }

    public function test_when_user_not_exists(): void
    {
        $email = fake()->safeEmail();

        $response = $this->getJson("/api/account/email_exists?email={$email}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.exists', false);
    }

    public function test_when_provided_email_is_incorrect(): void
    {
        $email = 'incorrect email';

        $response = $this->getJson("/api/account/email_exists?email={$email}");

        $response->assertStatus(422);
    }

    public function test_when_email_is_not_provided(): void
    {
        $response = $this->getJson("/api/account/email_exists");

        $response->assertStatus(422);
    }
}
