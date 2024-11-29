<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_can_set_product_name()
    {
        $product = new Product(name: 'Product Name!');

        $this->assertEquals('Product Name!', $product->getName());
    }

    public function test_should_create_new_product()
    {
        $product = new Product('Product Name', 'Product Description', 'Product Brand', 1);

        $this->assertTrue($product->save());

        $this->assertCount(1, Product::all());
    }
}
