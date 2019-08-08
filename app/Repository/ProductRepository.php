<?php

namespace App\Repository;

use App\Models\User;
use App\Models\Product;
use App\Repository\ImageRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var ImageRepository
     */
    private $imageRepo;

    public function __construct(Product $product, ImageRepository $image)
    {
        $this->product = $product;
        $this->imageRepo = $image;
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

    /**
     * Create a new product for vendor
     *
     * @param User $user
     * @param array $data
     * @return Product
     */
    public function create(User $user, array $data)
    {
        $product = $this->product->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'status' => isset($data['status']) ?? 'pending',
            'user_id' => $user->id
        ]);

        $this->insertImages($product, $data['images']);

        return $product;
    }

    /**
     * Upload and insert image to image gallery
     *
     * @param Product $product
     * @param array $images
     * @return void
     */
    public function insertImages(Product $product, array $images)
    {
        foreach ($images as $image) {
            $path = $this->imageRepo->upload($image, 'images/product');

            $product->images()->create(['image_path' => $path]);
        }
    }

    /**
     * Update a product with given data
     *
     * @param Product $product
     * @param array $data
     * @return Product
     */
    public function update(Product $product, array $data) : Product
    {
        $product->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
        ]);

        if (isset($data['images'])) {
            $this->insertImages($product, $data['images']);
        }

        return $product;
    }
}
