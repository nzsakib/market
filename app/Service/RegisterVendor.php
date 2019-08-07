<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Auth\Events\Registered;

class RegisterVendor
{
    use ValidatesRequests;

    public function handle(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
            'phone' => 'required',
        ]);

        $vendor = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => User::TYPE_VENDOR,
            'wallet' => 500,
            'phone' => $request->phone,
        ]);

        event(new Registered($vendor));

        return $vendor;
    }
}
