<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ProductService $productService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productService = $this->app->make(ProductService::class);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_creates_a_new_product()
    {
          $category = \App\Models\Category::factory()->create();

    $data = [
        'name' => 'Test Product',
        'price' => 123.45,
        'barcode' => '1234567890123',
        'category_id' => $category->id,
    ];

    $product = $this->productService->create($data);

    // Вот эти строки ОБЯЗАТЕЛЬНЫ!
    $this->assertInstanceOf(\App\Models\Product::class, $product);
    $this->assertDatabaseHas('products', [
        'name' => 'Test Product',
        'barcode' => '1234567890123',
    ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_updates_product_price()
    {
        $category = \App\Models\Category::factory()->create();
    $product = \App\Models\Product::factory()->create([
        'category_id' => $category->id,
        'price' => 100,
    ]);

    $updatedProduct = $this->productService->update($product->id, ['price' => 299.99]);

    // ОБЯЗАТЕЛЬНО!
    $this->assertEquals(299.99, $updatedProduct->price);
    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'price' => 299.99,
    ]);
    }

    // ЛИБО просто так:
    /*
    public function test_it_creates_a_new_product()
    {
        // тестовый код
    }

    public function test_it_updates_product_price()
    {
        // тестовый код
    }
    */
}