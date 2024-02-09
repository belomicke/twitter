<?php

namespace App\Services\Account;

use App\Services\User\UserHelpers;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class AccountService
{
    private array $profile_picture_sizes = [
        'small' => 128,
        'default' => 200,
        'large' => 400
    ];

    private array $profile_banner_sizes = [
        'default' => [600, 200],
        'large' => [1200, 600]
    ];

    public function saveProfilePicture(UploadedFile $file): array
    {
        $viewer = Auth::user();
        $image = Image::make($file);

        $filename = Str::random().'.'.explode('/', $image->mime())[1];

        foreach (array_keys($this->profile_picture_sizes) as $size) {
            $path = "public/profile_pictures/$size/$viewer->id/$filename";

            $image = Image::make($file)
                ->fit(
                    $this->profile_picture_sizes[$size],
                    $this->profile_picture_sizes[$size],
                    function ($constraint) {
                        $constraint->upsize();
                    }
                )
                ->encode('png');

            Storage::put($path, $image);
        }

        $viewer->profile_picture_filename = $filename;
        $viewer->save();

        return UserHelpers::getProfilePicturePaths($viewer->id, $filename);
    }

    public function deletePreviousProfilePicture(): void
    {
        $viewer = Auth::user();
        $filename = $viewer->profile_picture_filename;

        foreach (array_keys($this->profile_picture_sizes) as $size) {
            Storage::delete("public/profile_pictures/$size/$viewer->id/$filename");
        }
    }

    public function saveBannerPicture(UploadedFile $file): array
    {
        $viewer = Auth::user();
        $image = Image::make($file);

        $filename = Str::random().'.'.explode('/', $image->mime())[1];

        foreach (array_keys($this->profile_banner_sizes) as $size) {
            $path = "public/profile_banners/$size/$viewer->id/$filename";

            $image = Image::make($file)
                ->fit(
                    $this->profile_banner_sizes[$size][0],
                    $this->profile_banner_sizes[$size][1],
                    function ($constraint) {
                        $constraint->upsize();
                    }
                )
                ->encode('png');

            Storage::write($path, $image);
        }

        $viewer->profile_banner_filename = $filename;
        $viewer->save();

        return UserHelpers::getProfileBannerPaths($viewer->id, $filename);
    }

    public function deletePreviousProfileBanner(): void
    {
        $viewer = Auth::user();
        $filename = $viewer->profile_banner_filename;

        foreach (array_keys($this->profile_banner_sizes) as $size) {
            Storage::delete("public/profile_banners/$size/$viewer->id/$filename");
        }
    }
}
