<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OrderItem;
use Faker\Generator as Faker;
use App\Models\Product;
use App\Models\Order;

$factory->define(OrderItem::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            return factory(Product::class);
        },
        'quantity' => 1,
        'price' => 100,
        'order_id' => function () {
            return factory(Order::class);
        },
    ];
});
