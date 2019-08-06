<?php

namespace App\Repository;

use DB;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use App\Exceptions\InvalidFundException;

class CartRepository
{
    /**
     * @var Cart
     */
    private $userCart;

    /**
     * @var User
     */
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
    public function getCart(User $user)
    {
        $userCart = $user->cart;
        if ($userCart) {
            $userCart->load('cartItems');
        }

        return $userCart;
    }

    /**
     * Add a new product to cart
     *
     * @param User $user
     * @param Product $product
     * @return \App\Models\CartItem
     */
    public function add(User $user, Product $product)
    {
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
     * @param User $user
     * @param Product $product
     * @return boolean
     */
    public function remove(User $user, Product $product) : bool
    {
        return $user->cart->cartItems()->where('product_id', $product->id)->delete();
    }

    /**
     * Update the quantity of the cart item
     *
     * @param User $user
     * @param Product $product
     * @param integer $quantity
     * @return boolean
     */
    public function addQuantity(User $user, Product $product, int $quantity)
    {
        return $user->cart
                    ->cartItems()
                    ->where('product_id', $product->id)
                    ->update(['quantity' => $quantity]);
    }

    /**
     * get current total price of the products in carts
     *
     * @return integer $price
     */
    public function getTotalPrice(User $user) : int
    {
        if (!$user->cart) {
            return 0;
        }

        $total = $this->calculateTotalPrice($user->cart);

        return intval($total);
    }

    public function calculateTotalPrice(Cart $cart)
    {
        return CartItem::where('cart_id', $cart->id)
                ->join('products', 'products.id', '=', 'cart_items.product_id')
                ->select(\DB::raw('SUM(cart_items.quantity*price) as total'))
                ->first()->total;
    }

    /**
     * Place an order for the given user
     *
     * @param User $user
     * @param array $data
     * @return void
     */
    public function placeOrder(User $user, array $data)
    {
        DB::beginTransaction();
        try {
            $totalPrice = $this->updateUserWallet($user);

            $this->insertOrderItems($user, $totalPrice, $data);

            $this->emptyUserCart($user);

            DB::commit();
        } catch (InvalidFundException $e) {
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    private function updateUserWallet(User $user) : int
    {
        $totalPrice = $this->calculateTotalPrice($user->cart);

        if ($totalPrice > $user->wallet) {
            throw new InvalidFundException('You don\'t have anough fund in wallet. Plaease recharge.');
        }

        $user->wallet = $user->wallet - $totalPrice;
        $user->save();

        return $totalPrice;
    }

    private function insertOrderItems(User $user, int $totalPrice, array $data)
    {
        $cartItems = $user->cart->cartItems()->with('product')->get();

        $order = $user->orders()->create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
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

    /**
     * Empty out the given user cart
     *
     * @param User $user
     * @return boolean
     */
    public function emptyUserCart(User $user) : bool
    {
        return $user->cart->cartItems()->delete();
    }
}
