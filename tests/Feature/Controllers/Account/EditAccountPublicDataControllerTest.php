<?php

namespace Tests\Feature\Controllers\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EditAccountPublicDataControllerTest extends TestCase
{
    use RefreshDatabase;

    const EDIT_PUBLIC_DATA_URL = '/api/account/edit_public_data';
    const STRING_WITH_161_LENGTH = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vulputate, leo nec venenatis commodo, turpis felis mattis odio, eu vehicula risus tortor justo.';
    const LINK_WITH_101_LENGTH = 'https://toolonginthernetlink.com/example/hello/world/i/dont/know/what/type/here/else/how/about/some/tea';
    const CORRECT_LINK = 'https://random_link.com';

    private function auth(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);
    }

    public function test_fetch_without_token(): void
    {
        $response = $this->patchJson(self::EDIT_PUBLIC_DATA_URL);

        $response->assertStatus(401);
    }

    public function test_fetch_without_payload(): void
    {
        $this->auth();

        $response = $this->patchJson(self::EDIT_PUBLIC_DATA_URL);

        $response->assertStatus(422);
    }

    public function test_successful_case(): void
    {
        $this->auth();

        $name = 'random name';
        $bio = 'random bio';
        $location = 'random location';
        $link = self::CORRECT_LINK;

        $payload = [
            'name' => $name,
            'bio' => $bio,
            'location' => $location,
            'link' => $link
        ];

        $response = $this->patchJson(self::EDIT_PUBLIC_DATA_URL, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'bio' => $bio,
            'location' => $location,
            'link' => $link
        ]);
    }

    public function test_with_empty_bio_case(): void
    {
        $this->auth();

        $name = 'random name';
        $bio = '';
        $location = 'random location';
        $link = self::CORRECT_LINK;

        $payload = [
            'name' => $name,
            'bio' => $bio,
            'location' => $location,
            'link' => $link
        ];

        $response = $this->patchJson(self::EDIT_PUBLIC_DATA_URL, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'bio' => $bio,
            'location' => $location,
            'link' => $link
        ]);
    }

    public function test_with_too_long_bio_case(): void
    {
        $this->auth();

        $name = 'random name';
        $bio = self::STRING_WITH_161_LENGTH;

        $payload = [
            'name' => $name,
            'bio' => $bio,
        ];

        $response = $this->patchJson(self::EDIT_PUBLIC_DATA_URL, $payload);

        $response->assertStatus(422);
    }

    public function test_with_empty_location_case(): void
    {
        $this->auth();

        $name = 'random name';
        $bio = '';
        $location = '';
        $link = self::CORRECT_LINK;

        $payload = [
            'name' => $name,
            'bio' => $bio,
            'location' => $location,
            'link' => $link
        ];

        $response = $this->patchJson(self::EDIT_PUBLIC_DATA_URL, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'bio' => $bio,
            'location' => $location,
            'link' => $link
        ]);
    }

    public function test_with_too_long_location_case(): void
    {
        $this->auth();

        $name = 'random name';
        $location = self::STRING_WITH_161_LENGTH;

        $payload = [
            'name' => $name,
            'location' => $location,
        ];

        $response = $this->patchJson(self::EDIT_PUBLIC_DATA_URL, $payload);

        $response->assertStatus(422);
    }

    public function test_with_empty_link_case(): void
    {
        $this->auth();

        $name = 'random name';
        $bio = '';
        $location = '';
        $link = '';

        $payload = [
            'name' => $name,
            'bio' => $bio,
            'location' => $location,
            'link' => $link
        ];

        $response = $this->patchJson(self::EDIT_PUBLIC_DATA_URL, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'bio' => $bio,
            'location' => $location,
            'link' => $link
        ]);
    }

    public function test_with_too_long_link_case(): void
    {
        $this->auth();

        $name = 'random name';
        $link = self::LINK_WITH_101_LENGTH;

        $payload = [
            'name' => $name,
            'link' => $link,
        ];

        $response = $this->patchJson(self::EDIT_PUBLIC_DATA_URL, $payload);

        $response->assertStatus(422);
    }

    public function test_with_incorrect_link_case(): void
    {
        $this->auth();

        $name = 'random name';
        $link = 'broken link';

        $payload = [
            'name' => $name,
            'link' => $link,
        ];

        $response = $this->patchJson(self::EDIT_PUBLIC_DATA_URL, $payload);

        $response->assertStatus(422);
    }

}
