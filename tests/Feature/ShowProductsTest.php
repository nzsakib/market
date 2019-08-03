<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowProductsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_view_all_products()
    {
        $this->withoutExceptionHandling();
        $product = create(Product::class);

        $this->get('/')->assertSee($product->title)->assertSee($product->price);
    }

    /** @test */
    public function user_can_view_single_product()
    {
        $this->withoutExceptionHandling();

        $product = create(Product::class);

        $this->get("product/{$product->id}")
            ->assertSee($product->title)
            ->assertSee($product->description);
    }
}
