<?php

namespace App\Repository\Storage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Interfaces\EncodedImageInterface;

class StorageRepository
{
    public function save(
        UploadedFile|EncodedImageInterface $file,
        string $filename,
        string|null $folder
    ): void {
        $path = 'public/' . $folder . '/' . $filename;

        if (!$folder) {
            $path = 'public/' . $filename;
        }

        if ($file instanceof UploadedFile) {
            $contents = file_get_contents(filename: $file);
        } else {
            $contents = $file;
        }

        Storage::put(path: $path, contents: $contents);
    }

    public function deleteDirectory(
        string|null $folder
    ): void {
        $path = 'public/' . $folder;

        Storage::deleteDirectory(directory: $path);
    }
}
