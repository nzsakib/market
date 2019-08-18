<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ProductRepository;

class ProductController extends Controller
{
    private $productRepo;

    public function __construct(ProductRepository $product)
    {
        $this->productRepo = $product;
    }

    public function index()
    {
        $products = $this->productRepo->availableProducts();
        // dd($products);
        return view('home', compact('products'));
    }

    public function show($product)
    {
        $product = $this->productRepo->find($product);

        return view('product.show', compact('product'));
    }
}
