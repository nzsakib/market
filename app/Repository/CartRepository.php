<?php

namespace App\Repository;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Exceptions\InvalidFundException;
use Illuminate\Http\Request;

class CartRepository
{
    private $userCart;
    private $user;

    public function __construct()
    {
        $this->userCart = null;
    }

    /**
     * get user cart with cart items
     *
     * @param void
     * @return \App\Models\Cart
     */
    public function first()
    {
        $this->userCart = $userCart = auth()->user()->cart;
        if ($userCart) {
            $userCart->load('cartItems');
        }

        return $userCart;
    }

    /**
     * Add a new product to cart
     *
     * @param Product $product
     * @return \App\Models\CartItem
     */
    public function add(Product $product)
    {
        $user = auth()->user();
        $cart = $user->cart;
        if (!$cart) {
            $cart = $user->cart()->create();
        }

        $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();

        if (!$cartItem) {
            $cartItem = $cart->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return $cartItem;
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

    /**
     * Update the quantity of the cart item
     *
     * @param Product $product
     * @param integer $quantity
     * @return boolean
     */
    public function addQuantity(Product $product, int $quantity)
    {
        return auth()->user()->cart
                    ->cartItems()
                    ->where('product_id', $product->id)
                    ->update(['quantity' => $quantity]);
    }

    /**
     * get current total price of the products in carts
     *
     * @return integer $price
     */
    public function getTotalPrice() : int
    {
        if (!$this->userCart) {
            $this->userCart = auth()->user()->cart;
        }

        if (!$this->userCart) {
            return 0;
        }

        $total = $this->calculateTotalPrice($this->userCart);

        return intval($total);
    }

    public function calculateTotalPrice(Cart $cart)
    {
        return CartItem::where('cart_id', $cart->id)
                ->join('products', 'products.id', '=', 'cart_items.product_id')
                ->select(\DB::raw('SUM(cart_items.quantity*price) as total'))
                ->first()->total;
    }

    public function placeOrder(Request $request)
    {
        $this->user = auth()->user();
        $this->userCart = $this->user->cart;

        $totalPrice = $this->updateUserWallet();

        $this->insertOrderItems($totalPrice, $request);
    }

    private function updateUserWallet() : int
    {
        $totalPrice = $this->calculateTotalPrice($this->userCart);

        if ($totalPrice > $this->user->wallet) {
            throw new InvalidFundException('You don\'t have anough fund in wallet. Plaease recharge.');
        }

        $this->user->wallet = $this->user->wallet - $totalPrice;
        $this->user->save();

        return $totalPrice;
    }

    private function insertOrderItems(int $totalPrice, Request $request)
    {
        $cartItems = $this->user->cart->cartItems()->with('product')->get();

        $order = $this->user->orders()->create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'total' => $totalPrice
        ]);

        foreach ($cartItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item->product->id,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
            ]);
            $item->product->quantity -= $item->quantity;
            $item->product->save();
        }
    }
}
