<?php

namespace Tests\Feature;

use App\Models\Product;
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

    /** @test */
    public function guest_can_not_add_to_cart()
    {
        $this->post('/cart', ['product_id' => 1])->assertRedirect('/login');
    }

    /** @test */
    public function guest_can_not_delete_from_cart()
    {
        $customer = CustomerFactory::withCartItem(2)->create();

        $this->delete('/cart', ['product_id' => $customer->cart->cartItems[0]->product_id])->assertRedirect('/login');
    }

    /** @test */
    public function customer_can_not_add_to_cart_a_non_existant_product()
    {
        $this->customerSignIn();

        $this->post('/cart', ['product_id' => 1])->assertStatus(404);
    }

    /** @test */
    public function customer_can_list_cart_products()
    {
        $this->withoutExceptionHandling();
        $customer = CustomerFactory::withCartItem(3)->create();

        $this->actingAs($customer)
            ->get('/api/cart')
            ->assertStatus(200);
    }

    /** @test */
    public function user_can_update_item_quantity_in_cart()
    {
        $this->withoutExceptionHandling();
        $customer = CustomerFactory::withCartItem(1)->create();

        $this->actingAs($customer)
            ->post('/cart/update', [
                'product_id' => $customer->cart->cartItems[0]->product_id,
                'quantity' => 4,
            ]);

        $this->assertEquals(4, $customer->cart->cartItems->fresh()[0]->quantity);
    }

    /** @test */
    public function customer_can_checkout_a_cart()
    {
        $this->withoutExceptionHandling();
        $customer = CustomerFactory::withCartItem(1)->create();

        $data = [
            'name' => 'sakib',
            'phone' => '01212121',
            'address' => 'asdasdasd'
        ];
        $this->actingAs($customer)
            ->post(route('cart.checkout'), $data)
            ->assertRedirect(route('customer.order'));

        $this->assertCount(1, $customer->orders->first()->orderItems);
        $this->assertEquals(470, $customer->fresh()->wallet);
    }
}
