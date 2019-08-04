<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('login.customer');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            if ($user->type == User::TYPE_CUSTOMER) {
                return redirect()->route('customer.dashboard');
            }
        } else {
            return back()->withErrors(['message' => 'Invalid login credentials!!']);
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect('/');
    }
}
