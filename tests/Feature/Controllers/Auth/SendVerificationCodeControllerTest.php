<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SendVerificationCodeControllerTest extends TestCase
{
    use RefreshDatabase;

    const SEND_VERIFICATION_CODE_URL = '/api/auth/send_verification_code';
    const EXAMPLE_EMAIL = 'example@test.com';

    public function test_email_not_provided(): void
    {
        $response = $this->postJson(self::SEND_VERIFICATION_CODE_URL);

        $response->assertStatus(422);
    }

    public function test_email_is_not_correct(): void
    {
        $email = 'incorrect email';

        $response = $this->postJson(self::SEND_VERIFICATION_CODE_URL, ['email' => $email]);

        $response->assertStatus(422);
    }

    public function test_user_already_exists(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson(self::SEND_VERIFICATION_CODE_URL, ['email' => $user->email]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.message', 'User with current email already exists.');
    }

    public function test_verification_code_was_successfully_created(): void
    {
        $email = self::EXAMPLE_EMAIL;

        $response = $this->postJson(self::SEND_VERIFICATION_CODE_URL, ['email' => $email]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('verification_codes', [
            'email' => $email
        ]);
    }

    public function test_database_table_has_only_one_entity(): void
    {
        $email = self::EXAMPLE_EMAIL;

        $this->postJson(self::SEND_VERIFICATION_CODE_URL, ['email' => $email]);
        $this->postJson(self::SEND_VERIFICATION_CODE_URL, ['email' => $email]);

        $this->assertDatabaseCount('verification_codes', 1);
    }
}
