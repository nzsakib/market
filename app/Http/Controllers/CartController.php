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

        $product = $this->product->findOrFail($request->product_id);

        if ($product->quantity < 0) {
            return back()->withErrors("This product has no stocks remaining.");
        }

        $this->cart->add($product);

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

        $product = $this->product->find($request->product_id);

        if ($product->quantity < $request->quantity) {
            return back()->withErrors("This product has only {$product->quantity} stocks remaining.");
        }

        $this->cart->addQuantity(
            $product,
            $request->quantity
        );

        return back();
    }

    /**
     * Show a checkout page for customer
     *
     * @return View
     */
    public function showCheckout()
    {
        $total = $this->cart->getTotalPrice();

        return view('customer.checkout', compact('total'));
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
        if (is_null($user->cart) || $user->cart->isEmpty()) {
            return redirect('/');
        }

        $totalPrice = $this->cart->calculateTotalPrice($user->cart);

        if ($totalPrice > $user->wallet) {
            return redirect()->route('cart.index')->withErrors('You don\'t have enough fund in your wallet.');
        }
        $user->wallet = $user->wallet - $totalPrice;
        $user->save();

        $cartItems = $user->cart->cartItems()->with('product')->get();

        $order = $user->orders()->create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'total' => $totalPrice
        ]);

        foreach ($cartItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item->product->id,
                'price' => $item->product->price,
            ]);
            $item->product->quantity -= $item->quantity;
            $item->product->save();
        }

        return redirect()->route('customer.profile');
    }
}
