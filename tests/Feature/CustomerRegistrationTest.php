<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
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
            'password_confirmation' => '123456',
            'phone' => '01917169307'
        ];

        Notification::fake();
        $this->post('/register', $data)->assertRedirect(route('verification.notice'));

        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'type' => User::TYPE_CUSTOMER,
        ]);

        Notification::assertSentTo(User::where('email', $data['email'])->first(), VerifyEmail::class);
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
}
