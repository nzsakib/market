<?php

namespace Tests\Feature\Vendor;

use Tests\TestCase;
use Facades\Tests\Setup\VendorFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VendorProductTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function vendor_can_list_all_product()
    {
        $this->withoutExceptionHandling();

        $vendor = VendorFactory::withProduct(2)->create();

        $response = $this->actingAs($vendor)->get('/api/vendor/product')->assertStatus(200)->getContent();
        $result = json_decode($response)->data;

        $this->assertCount(2, $result);
    }
}
