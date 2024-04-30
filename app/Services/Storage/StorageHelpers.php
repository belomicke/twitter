<?php

namespace App\Services\Storage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class StorageHelpers
{
    public static function generateFilenameForFile(UploadedFile $file): string
    {
        $type = explode(
            separator: '/',
            string: $file->getMimeType()
        )[1];
        return Str::uuid()->toString() . '.' . $type;
    }
}
