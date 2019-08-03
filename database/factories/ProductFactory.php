<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'image' => 'https://placeimg.com/600/600/arch',
        'user_id' => function() {
            return factory('App\User');
        },
        'price' => 300,
        'quantity' => 5,
        'status' => 1,
    ];
});
