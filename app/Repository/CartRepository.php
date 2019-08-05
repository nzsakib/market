<?php

namespace App\Repository;

use App\Cart;
use App\Product;

class CartRepository
{
    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * get user cart with cart items
     *
     * @param void
     * @return \App\Cart
     */
    public function first()
    {
        $userCart = auth()->user()->cart;
        if ($userCart) {
            $userCart->load('cartItems');
        }

        return $userCart;
    }

    /**
     * Add a new product to cart
     *
     * @param Product $product
     * @return \App\CartItem
     */
    public function add(Product $product)
    {
        $user = auth()->user();
        $cart = $user->cart;
        if (!$cart) {
            $cart = $user->cart()->create();
        }

        return $cart->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    /**
     * Remove a product from user cart
     *
     * @param Product $product
     * @return boolean
     */
    public function remove(Product $product)
    {
        $user = auth()->user();

        return $user->cart->cartItems()->where('product_id', $product->id)->delete();
    }
}
