<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cart;
use App\Models\CartItem;
use Faker\Generator as Faker;
use App\Models\Product;

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
