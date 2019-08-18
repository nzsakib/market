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

    public function productDetails($productId)
    {
        return view('vendor.productDetails', compact('productId'));
    }

    public function newOrders()
    {
        $user = auth()->user();
        $orders = $user->vendorOrders()->with('product')->latest()->pending()->get();

        return view('vendor.newOrders', compact('orders'));
    }
}
