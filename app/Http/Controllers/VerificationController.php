<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        $token = $request->token;

        $token = Token::where('token', $token)->firstOrFail();

        $token->user->email_verified_at = now();
        $token->user->save();
        $token->delete();

        return redirect()->route('verify.success');
    }

    public function success()
    {
        return view('registration.success');
    }
}
