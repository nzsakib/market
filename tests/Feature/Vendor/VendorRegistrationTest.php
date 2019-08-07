<?php

namespace Tests\Feature\Vendor;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VendorRegistrationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function vendor_can_register()
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
        $this->post('/register?type=vendor', $data)->assertRedirect(route('verification.notice'));

        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'type' => User::TYPE_VENDOR,
        ]);

        Notification::assertSentTo(User::where('email', $data['email'])->first(), VerifyEmail::class);
    }
}
