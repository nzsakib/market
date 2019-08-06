<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Exceptions\InvalidFundException;

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
        $total = $this->cart->getTotalPrice(auth()->user());

        return view('customer.cart', compact('total'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        $product = $this->product->findOrFail($request->product_id);

        if ($product->quantity <= 0) {
            return back()->withErrors("This product has no stocks remaining.");
        }

        $this->cart->add(auth()->user(), $product);

        return back()->withMessage('Product added to cart.');
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        $this->cart->remove(
            auth()->user(),
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
            auth()->user(),
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
        $total = $this->cart->getTotalPrice(auth()->user());

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

        try {
            $this->cart->placeOrder(auth()->user(), $request->all());
        } catch (InvalidFundException $e) {
            return redirect()->route('cart.index')->withErrors($e->getMessage());
        }

        return redirect()->route('customer.order');
    }
}
