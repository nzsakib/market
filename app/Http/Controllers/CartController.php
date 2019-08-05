<?php

namespace App\Http\Controllers;

use App\Product;
use App\UseCase\UserCart;
use Illuminate\Http\Request;
use App\Repository\CartRepository;

class CartController extends Controller
{
    private $cart;

    public function __construct(CartRepository $cart)
    {
        $this->middleware('auth');
        $this->cart = $cart;
    }

    public function index()
    {
        $cart = $this->cart->first();

        return view('customer.cart', compact('cart'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        $product = Product::findOrFail($request->product_id);

        $this->cart->add($product);

        return back()->withMessage('Product added to cart.');
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        $product = Product::findOrFail($request->product_id);

        $this->cart->remove($product);

        return back()->withMessage('Product removed from cart.');
    }
}
