<?php

namespace Tests\Setup;

use App\User;
use App\CartItem;

class CustomerFactory
{
    private $cartItemCount;

    public function withCartItem($times = 0)
    {
        $this->cartItemCount = $times;

        return $this;
    }

    public function create()
    {
        $customer = create(User::class, ['type' => User::TYPE_CUSTOMER]);

        if ($this->cartItemCount) {
            $cart = $customer->cart()->create();
            create(CartItem::class, ['cart_id' => $cart->id], $this->cartItemCount);
        }

        return $customer;
    }
}
