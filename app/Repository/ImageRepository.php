<?php

namespace App\Repository;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Gallery;

class ImageRepository
{
    /**
     * @var Gallery
     */
    private $image;

    public function __Construct(Gallery $image)
    {
        $this->image = $image;
    }

    public function upload(UploadedFile $image, $folder = 'images/profile') : string
    {
        $filename = uniqid('profile_') . time() . '.' . $image->getClientOriginalExtension();

        $path = "{$folder}/{$filename}";

        Storage::disk('public')->put($path, File::get($image));

        return '/' . $path;
    }

    public function deleteFromDisk(string $imagePath)
    {
        return @unlink(storage_path('app/public') . $imagePath);
    }

    public function delete(Gallery $image)
    {
        return $image->delete();
    }

    public function findOrFail(int $imageId)
    {
        return $this->image->findOrFail($imageId);
    }
}
