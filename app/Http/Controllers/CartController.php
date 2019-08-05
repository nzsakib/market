<?php

namespace App\Http\Controllers;

use App\Product;
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

        return view('customer.cart', compact('cart'));
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
}
