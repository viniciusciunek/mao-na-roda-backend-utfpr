<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_should_create_new_problem(): void
    {
        $product = new Product(
            [
                'name' => 'Product Name',
                'description' => 'Product Description',
                'brand' => 'Product Brand',
                'price' => 1
            ]
        );

        $this->assertTrue($product->save());
        $this->assertCount(1, Product::all());
    }

    public function test_all_should_return_all_problems(): void
    {
        $products[] = new Product(
            [
                'name' => 'Product 1',
                'description' => 'Product 1',
                'brand' => 'Product 1',
                'price' => 1
            ]
        );

        $products[] = new Product(
            [
                'name' => 'Product 2',
                'description' => 'Product 2',
                'brand' => 'Product 2',
                'price' => 2
            ]
        );

        foreach ($products as $product) {
            $product->save();
        }

        $all = Product::all();

        $this->assertCount(2, $all);

        $this->assertEquals($products, $all);
    }

    public function test_destroy_should_remove_the_problem(): void
    {
        $product1 = new Product(
            [
                'name' => 'Product 1',
                'description' => 'Product 1',
                'brand' => 'Product 1',
                'price' => 1
            ]
        );
        $product2 = new Product(
            [
                'name' => 'Product 2',
                'description' => 'Product 2',
                'brand' => 'Product 2',
                'price' => 2
            ]
        );

        $product1->save();
        $product2->save();
        $product2->destroy();

        $this->assertCount(1, Product::all());
    }

    public function test_set_name(): void
    {
        $product = new Product(
            [
                'name' => 'Product 1',
                'description' => 'Product 1',
                'brand' => 'Product 1',
                'price' => 1
            ]
        );

        $this->assertEquals('Product 1', $product->name);
    }

    public function test_set_id(): void
    {
        $product = new Product(
            [
                'name' => 'Product 1',
                'description' => 'Product 1',
                'brand' => 'Product 1',
                'price' => 1
            ]
        );

        $product->id = 7;

        $this->assertEquals(7, $product->id);
    }

    public function test_errors_should_return_name_error(): void
    {
        $product = new Product(
            [
                'name' => 'Product 1',
                'description' => 'Product 1',
                'brand' => 'Product 1',
                'price' => 1
            ]
        );

        $product->name = '';

        $product->save();

        $this->assertFalse($product->isValid());
        $this->assertFalse($product->save());
        $this->assertFalse($product->hasErrors());

        $this->assertEquals('não pode ser vazio!', $product->errors('name'));
    }

    public function test_find_by_id_should_return_the_problem(): void
    {
        $product2 = new Product(
            [
                'name' => 'Product 2',
                'description' => 'Product 2',
                'brand' => 'Product 2',
                'price' => 2
            ]
        );

        $product1 = new Product(
            [
                'name' => 'Product 1',
                'description' => 'Product 1',
                'brand' => 'Product 1',
                'price' => 1
            ]
        );

        $product3 = new Product(
            [
                'name' => 'Product 3',
                'description' => 'Product 3',
                'brand' => 'Product 3',
                'price' => 3
            ]
        );

        $product1->save();
        $product2->save();
        $product3->save();

        $this->assertEquals($product1, Product::findById($product1->id));
    }

    public function test_find_by_id_should_return_null(): void
    {
        $product = new Product(
            [
                'name' => 'Product 1',
                'description' => 'Product 1',
                'brand' => 'Product 1',
                'price' => 1
            ]
        );

        $product->save();

        $this->assertNull(Product::findById(7));
    }
}
