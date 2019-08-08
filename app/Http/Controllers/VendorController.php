<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ProductRepository;

class VendorController extends Controller
{
    public function __construct(ProductRepository $repo)
    {
        $this->productRepo = $repo;
    }

    public function index()
    {
        return view('vendor.profile');
    }

    public function allProducts()
    {
        $products = $this->productRepo->getVendorProducts(auth()->user());

        return view('vendor.products');
    }

    public function addProduct()
    {
        return view('vendor.addProduct');
    }
}
