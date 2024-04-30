<?php

namespace App\Repository\Media;

use App\Models\Media;
use App\Repository\Storage\StorageRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class MediaRepository
{
    public function __construct(
        private readonly StorageRepository $storageRepository
    ) {}

    public function saveImage(int $postId, UploadedFile $file): Media
    {
        $id = Str::uuid()->toString();
        $type = explode('/', $file->getMimeType())[1];
        $filename = $id . '.' . $type;

        $image = Image::read($file);

        $width = $image->width();
        $height = $image->height();

        $media = Media::create([
            'post_id' => $postId,
            'filename' => $filename,
            'width' => $width,
            'height' => $height,
            'mime_type' => $file->getMimeType(),
        ]);
        $media->save();

        $this->storageRepository->save(
            file: $file,
            filename: $filename,
            folder: 'images',
        );

        return $media->fresh();
    }

    public function saveImages(int $postId, array $files): array
    {
        $media = [];

        foreach ($files as $file) {
            $media[] = $this->saveImage(
                postId: $postId,
                file: $file
            );
        }

        return $media;
    }

    public function getPostMedia(int $id): Collection|array
    {
        return Media::query()->where('post_id', $id)->get();
    }

    public function getMediaByPostIds(array $ids): Collection|array
    {
        return Media::query()->whereIn('post_id', $ids)->get();
    }
}
