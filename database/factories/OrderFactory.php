<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;
use App\Models\User;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class);
        },
        'total' => 300,
        'name' => $faker->name,
        'phone' => '0133333333',
        'address' => '135/A, Bashundhara',
        'status' => 'pending'
    ];
});
