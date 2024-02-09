<?php

namespace Tests\Feature\Controllers\Account\ProfileBanner;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ChangeProfileBannerControllerTest extends TestCase
{
    use RefreshDatabase;

    const URL = '/api/account/profile_banner';

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
            'banner.jpg',
            600,
            200
        )->size(100);

        $response = $this->postJson(self::URL, [
            'profile_banner' => $image
        ]);

        $response->assertJsonPath(
            'data.banners.default',
            "/storage/profile_banners/default/$user->id/$user->profile_banner_filename"
        );
        $response->assertStatus(200);
    }
}
