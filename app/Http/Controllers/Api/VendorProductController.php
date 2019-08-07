<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\ProductRepository;
use App\Http\Resources\ProductResource;

class VendorProductController extends Controller
{
    private $productRepo;

    public function __construct(ProductRepository $product)
    {
        $this->productRepo = $product;
    }

    /**
     * Get all product of authenticated vendor
     *
     * @return ProductResource
     */
    public function index()
    {
        $products = $this->productRepo->getVendorProducts(auth()->user());

        return ProductResource::collection($products);
    }
}
