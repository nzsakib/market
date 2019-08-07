<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorProductController extends Controller
{
    public function index()
    {
        // get all products of the vendor
        // $products = $this->productRepo->getVendorProduct(auth()->user());

        return view('vendor.products');
    }
}
