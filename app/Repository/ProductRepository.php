<?php

namespace App\Repository;

use App\Models\User;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function all()
    {
        return $this->product->all();
    }

    /**
     * Find a product with product id
     *
     * @param integer $productId
     * @return Product
     */
    public function find(int $productId) : ?Product
    {
        return $this->product->find($productId);
    }

    /**
     * Find a product with product id or throw a 404 exception
     *
     * @param integer $productId
     * @return Product
     */
    public function findOrFail(int $productId) : Product
    {
        return $this->product->findOrFail($productId);
    }

    public function getVendorProducts(User $user, int $perPage = 15) : LengthAwarePaginator
    {
        return $user->products()->paginate($perPage);
    }
}
