<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use Lib\Paginator;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_can_set_product_name(): void
    {
        $product = new Product(name: 'Product Name!');

        $this->assertEquals('Product Name!', $product->getName());
    }

    public function test_should_create_new_product(): void
    {
        $product = new Product(
            name: 'Product Name',
            description: 'Product Description',
            brand: 'Product Brand',
            price: 1
        );

        $this->assertTrue($product->save());

        $this->assertCount(1, Product::all());
    }

    public function test_should_return_a_paginator(): void
    {
        $this->assertInstanceOf(Paginator::class, Product::paginate());
    }
}
