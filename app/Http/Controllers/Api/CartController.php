<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repository\CartRepository;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    private $cartRepo;

    public function __construct(CartRepository $cart)
    {
        $this->middleware('auth');
        $this->cartRepo = $cart;
    }

    public function index()
    {
        $cart = $this->cartRepo->getCart(auth()->user());

        CartResource::withoutWrapping();
        return new CartResource($cart);
    }
}
