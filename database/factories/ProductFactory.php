<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;
use App\Models\User;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'image' => 'https://placeimg.com/600/600/arch',
        'user_id' => function () {
            return factory(User::class);
        },
        'price' => 30,
        'quantity' => 5,
        'status' => 1,
    ];
});
