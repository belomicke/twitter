<?php

namespace Tests\Feature\Controllers\Account\ProfilePicture;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteProfilePictureControllerTest extends TestCase
{
    use RefreshDatabase;

    const URL = '/api/account/profile_picture';

    public function test_success_case(): void
    {
        $user = User::factory()->create();
        $user->profile_picture_filename = 'sdadsadasd.png';
        $user->save();

        Sanctum::actingAs($user);

        $response = $this->deleteJson(self::URL);
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'profile_picture_filename' => 'default-profile-picture.png'
        ]);

    }
}
