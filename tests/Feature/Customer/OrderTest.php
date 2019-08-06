<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Facades\Tests\Setup\CustomerFactory;

class OrderTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function customer_can_view_single_order_details()
    {
        $this->withoutExceptionHandling();
        $customer = CustomerFactory::withOrder(1)->create();
        $order = $customer->orders->first();
        $this->actingAs($customer)
            ->get(route('customer.orderDetails', $order->id))
            ->assertStatus(200)
            ->assertSee($order->name);
    }
}
