<?php

namespace App\Repository;

use App\Models\Product;

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
    public function find(int $productId) : Product
    {
        return $this->product->findOrFail($productId);
    }
}
