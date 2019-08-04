<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailAddress;

class SendVerificationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $token = $this->getToken($event->user)->token;

        Mail::to($event->user->email)->send(new VerifyEmailAddress($token));
    }

    private function getToken($user)
    {
        if ($user->verificationToken) {
            return $user->verificationToken;
        }

        return $user->generateToken();
    }
}
