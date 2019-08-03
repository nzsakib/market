<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ClientAccountTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_guest_can_register()
    {
        $this->withoutExceptionHandling();

        $data = [
            'email' => 'test@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ];
        
        $this->post('/register', $data)
            ->assertRedirect('/email-notify');
    }
}
