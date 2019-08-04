<?php

namespace App\Http\Controllers;

use App\Product;
use App\UseCase\UserCart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = auth()->user()->cart;

        if ($cart) {
            $items = $cart->cartItems()->with('product')->get();
        } else {
            return redirect('/');
        }
        return view('customer.cart', compact('items'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        $product = Product::findOrFail($request->product_id);

        (new UserCart)->add($product);

        return back()->withMessage('Product added to cart.');
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        $product = Product::findOrFail($request->product_id);
        (new UserCart)->remove($product);

        return back()->withMessage('Product removed from cart.');
    }
}
