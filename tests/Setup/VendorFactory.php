<?php

namespace Tests\Setup;

use App\Models\User;
use App\Models\Product;

class VendorFactory
{
    private $productCount = 0;

    public function withProduct($times = 0)
    {
        $this->productCount = $times;

        return $this;
    }

    public function create()
    {
        $vendor = create(User::class, ['type' => User::TYPE_VENDOR]);

        create(Product::class, ['user_id' => $vendor->id], $this->productCount);

        return $vendor;
    }
}
