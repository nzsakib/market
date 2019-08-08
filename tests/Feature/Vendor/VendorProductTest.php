<?php

namespace Tests\Feature\Vendor;

use Tests\TestCase;
use Facades\Tests\Setup\VendorFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use App\Models\Product;

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

    /** @test */
    public function vendor_can_create_a_product()
    {
        $this->withoutExceptionHandling();

        $data = $this->getProductData();

        $this->vendorSignIn();

        $this->post('/api/vendor/product', $data)->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'title' => $data['title']
        ]);

        $this->assertCount(1, auth()->user()->products->first()->images);
    }

    /** @test */
    public function vendor_can_update_product()
    {
        $this->withoutExceptionHandling();

        $vendor = VendorFactory::withProduct(1)->create();
        $product = $vendor->products->first();

        $data = $this->getProductData();

        $this->actingAs($vendor)
            ->patch("/api/vendor/product/{$product->id}", $data)
            ->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'quantity' => $data['quantity'],
            'price' => $data['price'],
        ]);

        $this->assertCount(1, $product->images);
    }

    /** @test */
    public function vendor_can_not_update_other_vendors_product()
    {
        $product = create(Product::class);

        $this->vendorSignIn();

        $this->patch("/api/vendor/product/{$product->id}", $this->getProductData())->assertStatus(403);
    }

    protected function getProductData() : array
    {
        return [
            'title' => 'changed title',
            'description' => 'changed',
            'quantity' => 10,
            'price' => 100,
            'images' => [
                UploadedFile::fake()->image('img.png')
            ]
        ];
    }
}
