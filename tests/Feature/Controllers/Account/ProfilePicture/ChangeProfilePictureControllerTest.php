<?php

namespace Tests\Feature\Controllers\Account\ProfilePicture;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ChangeProfilePictureControllerTest extends TestCase
{
    use RefreshDatabase;

    const URL = '/api/account/profile_picture';

    public function test_with_no_payload(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson(self::URL);

        $response->assertStatus(422);
    }

    public function test_success_case(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $image = UploadedFile::fake()->image(
            'avatar.jpg',
            200,
            200
        )->size(100);

        $response = $this->postJson(self::URL, [
            'profile_picture' => $image
        ]);

        $response->assertJsonPath(
            'data.pictures.default',
            "/storage/profile_pictures/default/$user->id/$user->profile_picture_filename"
        );
        $response->assertStatus(200);
    }
}
