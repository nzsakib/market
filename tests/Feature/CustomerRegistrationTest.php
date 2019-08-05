<?php

namespace Tests\Feature;

use App\Models\User;
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

    /** @test */
    public function customer_requires_email_address()
    {
        $data = [
            'name' => 'john doe',
            'password' => '123456',
            'password_confirmation' => '123456'
        ];

        $this->post('/register', $data)->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function customer_requires_a_name()
    {
        $data = [
            'password' => '123456',
            'email' => 'test@gmail.com',
            'password_confirmation' => '123456'
        ];

        $this->post('/register', $data)->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function customer_requires_password()
    {
        $data = [
            'name' => 'john doe',
            'email' => 'test@gmail.com'
        ];

        $this->post('/register', $data)->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function customer_can_verify_email_address()
    {
        $this->withoutExceptionHandling();

        $user = create(User::class, ['email_verified_at' => null]);
        $token = $user->generateToken()->token;

        $this->get("/verify?token={$token}");

        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
