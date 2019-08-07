<?php

namespace App\Repository;

use App\Models\User;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository
{
    /**
     * @var Product
     */
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

    /**
     * Get all products of a vendor
     *
     * @param User $user
     * @param integer $perPage
     * @return LengthAwarePaginator
     */
    public function getVendorProducts(User $user, int $perPage = 15) : LengthAwarePaginator
    {
        return $user->products()->paginate($perPage);
    }

    public function create(User $user, array $data)
    {
        return $this->product->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'status' => isset($data['status']) ?? 'pending',
            'user_id' => $user->id
        ]);
    }
}
