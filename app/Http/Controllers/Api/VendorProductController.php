<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\ProductRepository;
use App\Http\Resources\ProductResource;

class VendorProductController extends Controller
{
    /**
     * @var ProductRepository
     */
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

    /**
     * Create a new product by the vendor
     *
     * @param Request $request
     * @return
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'quantity' => 'required|int',
            'price' => 'required',
            'images' => 'required|array'
        ]);

        $product = $this->productRepo->create(auth()->user(), $request->all());

        return response([
            'success' => true,
            'message' => 'Product was created',
            'product' => $product
        ]);
    }

    public function update(int $productId, Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'images' => 'sometimes|array'
        ]);

        $product = $this->productRepo->findOrFail($productId);

        $this->authorize('update', $product);

        $product = $this->productRepo->update($product, $request->all());

        return response([
            'success' => true,
            'message' => 'Product updated',
            'product' => $product->load('images') // Change to product resource
        ]);
    }
}
