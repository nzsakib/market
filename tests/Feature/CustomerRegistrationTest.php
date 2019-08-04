<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Mail\VerifyEmailAddress;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomerRegistrationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_guest_can_register_as_customer()
    {
        $this->withoutExceptionHandling();

        $data = [
            'name' => 'john doe',
            'email' => 'test@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ];

        Mail::fake();
        $this->post('/register', $data)->assertRedirect(route('register.notify'));

        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'type' => User::TYPE_CUSTOMER,
        ]);

        Mail::assertSent(VerifyEmailAddress::class, function ($mail) use ($data) {
            return  $mail->hasTo($data['email']);
        });
    }
}
