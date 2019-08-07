<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\RegisterVendor;
use App\Service\RegisterCustomer;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        // (new RegistrationRepository)->register($request);
        $this->getRegistrationMethod()->handle($request);

        return redirect()->route('verification.notice');
    }

    public function getRegistrationMethod()
    {
        if (request('type') === 'vendor') {
            return new RegisterVendor;
        }

        return new RegisterCustomer;
    }

    public function show()
    {
        if (request('type') === 'vendor') {
            return view('registration.vendor', ['vendor' => true]);
        }
        return view('registration.customer', ['vendor' => false]);
    }

    public function emailNotify()
    {
        return view('registration.notify');
    }
}
