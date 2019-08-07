<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\PasswordDoesNotMatch;

class UserRepository
{
    public function __construct(ImageRepository $image)
    {
        $this->imageRepo = $image;
    }

    /**
     * Update user profile
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function update(User $user, array $data) : User
    {
        $user->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'address' => $data['address'],
        ]);

        return $user;
    }

    /**
     * Update user profile image
     *
     * @param User $user
     * @param UploadedFile $image
     * @return string image relative path
     */
    public function updateImage(User $user, UploadedFile $image) : string
    {
        if ($user->profile_image !== 'http://market.test/storage/images/profile/default.png') {
            $this->imageRepo->delete($user->profile_image);
        }
        $path = $this->imageRepo->upload($image);

        $user->profile_image = $path;
        $user->save();

        return $path;
    }

    public function updatePassword(User $user, array $data)
    {
        if (!Hash::check($data['current_password'], $user->password)) {
            throw new PasswordDoesNotMatch('Current password does not match!!');
        }

        $user->password = bcrypt($data['new_password']);

        return $user->save();
    }
}
