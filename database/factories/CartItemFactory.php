<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cart;
use App\CartItem;
use Faker\Generator as Faker;
use App\Product;

$factory->define(CartItem::class, function (Faker $faker) {
    return [
        'cart_id' => function () {
            return factory(Cart::class);
        },
        'product_id' => function () {
            return factory(Product::class);
        },
        'quantity' => 1
    ];
});
