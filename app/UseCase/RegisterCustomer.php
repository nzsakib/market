<?php

namespace App\UseCase;

use App\User;
use Illuminate\Http\Request;
use App\Events\CustomerRegistered;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RegisterCustomer
{
    use ValidatesRequests;

    public function handle(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5'
        ]);

        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => User::TYPE_CUSTOMER,
        ]);

        event(new CustomerRegistered($customer));
    }
}
