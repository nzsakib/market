<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;

class CartController extends Controller
{
    private $cart;
    private $product;

    public function __construct(CartRepository $cart, ProductRepository $product)
    {
        $this->middleware('auth');
        $this->cart = $cart;
        $this->product = $product;
    }

    public function index()
    {
        $cart = $this->cart->first();
        $total = $this->cart->getTotalPrice();

        return view('customer.cart', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        $this->cart->add(
            $this->product->find($request->product_id)
        );

        return back()->withMessage('Product added to cart.');
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        $this->cart->remove(
            $this->product->find($request->product_id)
        );

        return back()->withMessage('Product removed from cart.');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'quantity' => 'required|int|min:1'
        ]);

        $this->cart->addQuantity(
            $this->product->find($request->product_id),
            $request->quantity
        );

        return back();
    }

    /**
     * Checkout a user cart
     *
     * @return void
     */
    public function checkout(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $user = auth()->user();
        if ($user->cart->isEmpty()) {
            return redirect('/');
        }

        $cartItems = $user->cart->cartItems()->with('product')->get();

        $order = $user->orders()->create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'total' => $this->cart->calculateTotalPrice($user->cart)
        ]);

        foreach ($cartItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item->product->id,
                'price' => $item->product->price,
            ]);
        }

        return redirect('customer.profile');
    }
}
