<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repository\UserRepository;
use App\Http\Controllers\Controller;
use App\Exceptions\PasswordDoesNotMatch;

class CustomerProfileController extends Controller
{
    public function __construct(UserRepository $user)
    {
        $this->middleware('auth');
        $this->userRepo = $user;
    }

    public function index()
    {
        $user = auth()->user();

        return $user;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required'
        ]);

        $user = $this->userRepo->update(auth()->user(), $request->all());

        return response([
            'success' => true,
            'message' => 'Profile updated.',
            'user' => $user
        ]);
    }

    /**
     * Update user profile photo
     *
     * @param Request $request
     * @return Response
     */
    public function updatePhoto(Request $request)
    {
        $this->validate($request, [
            'photo' => 'file|required'
        ]);

        $url = $this->userRepo->updateImage(auth()->user(), $request->photo);

        return response([
            'success' => true,
            'message' => 'Image Updated',
            'path' => $url
        ]);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        try {
            $this->userRepo->updatePassword(auth()->user(), $request->all());
        } catch (PasswordDoesNotMatch $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }

        return response([
            'success' => true,
            'message' => 'Password Updated'
        ]);
    }
}
