<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn($user) 
    {
        $user = $user ?? factory('App\User');

        $this->actingAs($user);

        return $user;
    }
}
