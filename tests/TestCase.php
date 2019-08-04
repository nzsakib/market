<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function customerSignIn($user = null)
    {
        $user = $user ?? create(User::class, ['type' => User::TYPE_CUSTOMER]);

        $this->actingAs($user);

        return $user;
    }
}
