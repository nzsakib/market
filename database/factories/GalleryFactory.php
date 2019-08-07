<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Gallery;
use Faker\Generator as Faker;
use App\Models\Product;

$factory->define(Gallery::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            return factory(Product::class);
        },
        'image_path' => 'https://placeimg.com/600/600/arch'
    ];
});
