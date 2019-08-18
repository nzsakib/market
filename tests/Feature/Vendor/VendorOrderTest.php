<?php

namespace Tests\Feature\Vendor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\VendorFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VendorOrderTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function vendor_can_see_all_new_orders()
    {
        $this->withoutExceptionHandling();

        $vendor = VendorFactory::withOrder(2)->create();
        $this->actingAs($vendor);
        $this->get('/vendor/orders/new')->assertStatus(200)
            ->assertSee($vendor->products[0]->title);
    }
}
