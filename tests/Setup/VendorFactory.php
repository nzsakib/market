<?php

namespace Tests\Setup;

use App\Models\User;
use App\Models\Product;
use App\Models\Gallery;

class VendorFactory
{
    private $productCount = 0;

    private $imageCount = 0;

    public function withProduct($times = 0)
    {
        $this->productCount = $times;

        return $this;
    }

    public function withImage($times = 0)
    {
        $this->imageCount = $times;

        return $this;
    }

    public function create()
    {
        $vendor = create(User::class, ['type' => User::TYPE_VENDOR]);

        $product = create(Product::class, ['user_id' => $vendor->id], $this->productCount);

        $this->createImage($product);

        // create(Gallery::class, ['product_id' => $product->id], $this->imageCount);

        return $vendor;
    }

    public function createImage($product)
    {
        if ($product instanceof \Illuminate\Database\Eloquent\Collection) {
            foreach ($product as $item) {
                create(Gallery::class, ['product_id' => $item->id], $this->imageCount);
            }
        } else {
            create(Gallery::class, ['product_id' => $product->id], $this->imageCount);
        }
    }
}
