<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowProductsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_view_all_products()
    {
        // $product = factory(Product::class)->create();

        $this->get('/')->assertStatus(200);
    }
}
