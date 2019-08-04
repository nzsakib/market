<?php

namespace App\UseCase;

use App\Product;

class UserCart
{
    public function add(Product $product)
    {
        $user = auth()->user();
        $cart = $user->cart;
        if (!$cart) {
            $cart = $user->cart()->create();
        }

        $cart->add($product);
    }

    public function remove(Product $product)
    {
        $user = auth()->user();

        return $user->cart->cartItems()->where('product_id', $product->id)->delete();
    }
}
