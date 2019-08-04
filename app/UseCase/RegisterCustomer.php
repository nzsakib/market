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
            'email' => 'required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        event(new CustomerRegistered($customer));
    }
}
