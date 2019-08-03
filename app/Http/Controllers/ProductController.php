<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index() 
    {
        $products = Product::all();
        return view('home', compact('products'));
    }

    public function show(Product $product) 
    {
        return view('product.show', compact('product'));
    }
}
