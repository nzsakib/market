<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class CustomerLoginTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function customer_can_login_to_dashboard()
    {
        $this->withoutExceptionHandling();
        $customer = create(User::class, [
            'password' => bcrypt('12345'),
            'type' => User::TYPE_CUSTOMER
        ]);

        $this->post('/login', [
            'email' => $customer->email,
            'password' => '12345'
        ])->assertRedirect(route('customer.profile'));
    }

    /** @test */
    public function email_is_required_to_login()
    {
        $this->post('/login', [
            'password' => '123'
        ])->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function password_is_required_to_login()
    {
        $this->post('/login', [
            'email' => 'john@doe.com'
        ])->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function user_can_not_login_with_invalid_credentials()
    {
        $customer = create(User::class, ['type' => User::TYPE_CUSTOMER]);

        $this->post('/login', [
            'email' => $customer->email,
            'password' => 'notsecret'
        ])->assertSessionHasErrors();
    }
}
