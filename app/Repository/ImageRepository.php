<?php

namespace App\Repository;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageRepository
{
    public function upload(UploadedFile $image, $folder = 'images/profile') : string
    {
        $filename = uniqid('profile_') . time() . '.' . $image->getClientOriginalExtension();

        $path = "{$folder}/{$filename}";

        Storage::disk('public')->put($path, File::get($image));

        return '/' . $path;
    }

    public function delete(string $imagePath)
    {
        return @unlink(storage_path('app/public') . $imagePath);
    }
}
