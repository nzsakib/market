<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCase\RegisterCustomer;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        $this->getRegistrationMethod()->handle($request);

        return redirect()->route('register.notify');
    }

    public function getRegistrationMethod()
    {
        // if (request('type') === 'vendor') {
        //     return new RegisterVendor();
        // }

        return new RegisterCustomer;
    }

    public function show()
    {
        return view('registration.customer');
    }

    public function emailNotify()
    {
        return view('registration.notify');
    }
}
