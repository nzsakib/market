<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ProductRepository;

class ProductController extends Controller
{
    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $products = $this->product->all();

        return view('home', compact('products'));
    }

    public function show($product)
    {
        $product = $this->product->find($product);

        return view('product.show', compact('product'));
    }
}
