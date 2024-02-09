<?php

namespace App\Services\User;

class UserHelpers
{
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
}
