<?php

namespace Tests\Setup;

use App\Models\User;
use App\Models\CartItem;
use App\Models\Order;

class CustomerFactory
{
    private $cartItemCount = 0;
    private $orderCount = 0;

    public function withCartItem($times = 0)
    {
        $this->cartItemCount = $times;

        return $this;
    }

    public function withOrder($times = 0)
    {
        $this->orderCount = $times;

        return $this;
    }

    public function create()
    {
        $customer = create(User::class, ['type' => User::TYPE_CUSTOMER]);

        if ($this->cartItemCount) {
            $cart = $customer->cart()->create();
            create(CartItem::class, ['cart_id' => $cart->id], $this->cartItemCount);
        }

        create(Order::class, ['user_id' => $customer->id], $this->orderCount);

        return $customer;
    }
}
