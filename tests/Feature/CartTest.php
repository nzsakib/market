<?php

namespace Tests\Feature;

use App\User;
use App\Product;
use Tests\TestCase;
use Facades\Tests\Setup\CustomerFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CartTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function customer_can_add_a_product_to_cart()
    {
        $this->withoutExceptionHandling();
        $this->customerSignIn();
        $product = create(Product::class);

        $this->post('/cart', [
            'product_id' => $product->id,
        ]);

        $this->assertCount(1, auth()->user()->fresh()->cart->cartItems);
    }

    /** @test */
    public function customer_can_remove_product_from_cart()
    {
        $this->withoutExceptionHandling();

        $customer = CustomerFactory::withCartItem(2)->create();

        $this->actingAs($customer)
            ->delete('/cart', ['product_id' => $customer->cart->cartItems[0]->product_id]);

        $this->assertCount(1, $customer->fresh()->cart->cartItems);
    }
}
