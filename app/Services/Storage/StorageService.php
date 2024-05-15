<?php

namespace App\Services\Storage;

use App\Helpers\StorageHelpers;
use App\Helpers\UserHelpers;
use App\Repository\Storage\StorageRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Laravel\Facades\Image;

class StorageService
{
    private array $profileBannerSizes;
    private array $profilePictureSizes;

    public function __construct(
        private readonly StorageRepository $storageRepository
    ) {
        $this->profileBannerSizes = UserHelpers::getProfileBannerSizes();
        $this->profilePictureSizes = UserHelpers::getProfilePictureSizes();
    }

    public function saveProfilePicture(UploadedFile $file): string
    {
        $filename = StorageHelpers::generateFilenameForFile(file: $file);

        foreach (array_keys(array: $this->profilePictureSizes) as $size) {
            $folder = UserHelpers::generatePathToProfilePictureFolder(
                size: $size,
                id: Auth::id()
            );

            $image = Image::read(input: $file)
                ->resize(
                    width: $this->profilePictureSizes[$size],
                    height: $this->profilePictureSizes[$size],
                )
                ->encode(encoder: new JpegEncoder);

            $this->storageRepository->save(
                file: $image,
                filename: $filename,
                folder: $folder
            );
        }

        return $filename;
    }

    public function deleteProfilePicture(): void
    {
        foreach (array_keys(array: $this->profilePictureSizes) as $size) {
            $folder = UserHelpers::generatePathToProfilePictureFolder(
                size: $size,
                id: Auth::id(),
            );
            $this->storageRepository->deleteDirectory(folder: $folder);
        }
    }

    public function saveProfileBanner(UploadedFile $file): string
    {
        $filename = StorageHelpers::generateFilenameForFile(file: $file);

        foreach (array_keys(array: $this->profileBannerSizes) as $size) {
            $folder = UserHelpers::generatePathToProfileBannerFolder(
                size: $size,
                id: Auth::id()
            );

            $image = Image::read(input: $file)
                ->resize(
                    width: $this->profileBannerSizes[$size][0],
                    height: $this->profileBannerSizes[$size][1],
                )->encode(encoder: new JpegEncoder);

            $this->storageRepository->save(
                file: $image,
                filename: $filename,
                folder: $folder
            );
        }

        return $filename;
    }

    public function deleteProfileBanner(): void
    {
        foreach (array_keys(array: $this->profileBannerSizes) as $size) {
            $folder = UserHelpers::generatePathToProfileBannerFolder(
                size: $size,
                id: Auth::id()
            );
            $this->storageRepository->deleteDirectory(folder: $folder);
        }
    }
}
