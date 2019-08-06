<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\UserRepository;

class CustomerProfileController extends Controller
{
    public function __construct(UserRepository $user)
    {
        // $this->middleware('auth');
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

    public function updatePhoto(Request $request)
    {
        $this->validate($request, [
            'photo' => 'file|required'
        ]);
        auth()->loginUsingId(11);

        $this->userRepo->updateImage(auth()->user(), $request->photo);

        return response([
            'success' => true,
            'message' => 'Image Updated'
        ]);
    }
}
