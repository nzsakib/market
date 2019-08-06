<?php

namespace App\Repository;

use Illuminate\Http\UploadedFile;

class ImageRepository
{
    public function upload(UploadedFile $image, $folder = 'profile')
    {
        $filename = uniqid('profile_') . time() . $image->getClientOriginalExtension();

        $path = "images/{$folder}/";
        $image->move($path, $filename);

        return "{$path}{$filename}";
    }
}
