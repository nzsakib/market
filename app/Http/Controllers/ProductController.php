<?php

namespace App\Http\Controllers;

use App\Product;
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

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }
}
