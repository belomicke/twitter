<?php

namespace App\Services\Account;

use App\Helpers\UserHelpers;
use App\Models\User;
use App\Repository\Account\ViewerRepository;
use App\Services\Storage\StorageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class AccountService
{
    public function __construct(
        private readonly StorageService $storageService,
        private readonly ViewerRepository $viewerRepository,
    ) {}

    public function editProfileInfo(
        string $name,
        string|null $bio,
        string|null $location,
        string|null $link
    ): User {
        $viewer = $this->viewerRepository->getViewer();

        $viewer->name = $name;
        $viewer->bio = $bio ?? '';
        $viewer->location = $location ?? '';
        $viewer->link = $link ?? '';

        $viewer->save();

        return $viewer;
    }

    public function saveProfilePicture(UploadedFile $file): array
    {
        $viewer = $this->viewerRepository->getViewer();

        if ($viewer->profile_picture_is_default) {
            $this->storageService->deleteProfilePicture();
        }

        $filename = $this->storageService->saveProfilePicture(file: $file);
        $viewer->profile_picture_filename = $filename;
        $viewer->save();

        return UserHelpers::getProfilePicturePaths(
            id: $viewer->id,
            filename: $filename
        );
    }

    public function deleteProfilePicture(): array
    {
        $viewer = $this->viewerRepository->getViewer();
        $profilePictureFilenameDefaultValue = UserHelpers::getDefaultProfilePictureFilenameValue();

        $this->storageService->deleteProfilePicture();
        $viewer->profile_picture_filename = $profilePictureFilenameDefaultValue;
        $viewer->save();

        return UserHelpers::getProfilePicturePaths(
            id: Auth::id(),
            filename: $profilePictureFilenameDefaultValue
        );
    }

    public function saveProfileBanner(UploadedFile $file): array
    {
        $viewer = $this->viewerRepository->getViewer();

        if ($viewer->profile_banner_filename !== '') {
            $this->storageService->deleteProfileBanner();
        }

        $filename = $this->storageService->saveProfileBanner(file: $file);
        $viewer->profile_banner_filename = $filename;
        $viewer->save();

        return UserHelpers::getProfileBannerPaths(
            id: $viewer->id,
            filename: $filename
        );
    }

    public function deleteProfileBanner(): array
    {
        $viewer = $this->viewerRepository->getViewer();

        $this->storageService->deleteProfileBanner();
        $viewer->profile_banner_filename = '';
        $viewer->save();

        return UserHelpers::getProfileBannerPaths(
            id: Auth::id(),
            filename: ''
        );
    }
}
