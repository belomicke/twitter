<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Validator;

class UserHelpers
{
    public static function getDefaultProfilePictureFilenameValue(): string
    {
        return 'default-profile-picture.png';
    }

    public static function getProfilePictureSizes(): array
    {
        return [
            'small' => 128,
            'default' => 200,
            'large' => 400
        ];
    }

    public static function getProfileBannerSizes(): array
    {
        return [
            'default' => [600, 200],
            'large' => [1200, 600]
        ];
    }

    public static function getProfilePicturePaths(int $id, string $filename): array
    {
        if ($filename === 'default-profile-picture.png') {
            return [
                'small' => "/storage/profile_pictures/$filename",
                'default' => "/storage/profile_pictures/$filename",
                'large' => "/storage/profile_pictures/$filename",
            ];
        }

        return [
            'small' => "/storage/profile_pictures/small/$id/$filename",
            'default' => "/storage/profile_pictures/default/$id/$filename",
            'large' => "/storage/profile_pictures/large/$id/$filename",
        ];
    }

    public static function getProfileBannerPaths(int $id, string $filename): array
    {
        if ($filename === '') {
            return [
                'default' => "",
                'large' => "",
            ];
        }

        return [
            'default' => "/storage/profile_banners/default/$id/$filename",
            'large' => "/storage/profile_banners/large/$id/$filename",
        ];
    }

    public static function generatePathToProfileBannerFolder(string $size, int $id): string
    {
        return "profile_banners/$size/$id";
    }

    public static function generatePathToProfilePictureFolder(string $size, int $id): string
    {
        return "profile_pictures/$size/$id";
    }

    public static function checkLinkIsValid(string $link): bool
    {
        $data = [
            'link' => $link
        ];

        $rules = [
            'link' => 'url'
        ];

        return Validator::make($data, $rules)->fails();
    }
}
