<?php

namespace Tests\Unit\Controllers;

use App\Models\Product;

class ProductsControllerTest extends BaseControllerTestCase
{
    public function test_list_all_products(): void
    {
        $products[] = new Product(
            ['name' => 'Product 1', 'description' => 'Product 1', 'brand' => 'Product 1', 'price' => 1]
        );
        $products[] = new Product(
            ['name' => 'Product 2', 'description' => 'Product 2', 'brand' => 'Product 2', 'price' => 2]
        );

        foreach ($products as $product) {
            $product->save();
        }

        $response = $this->get('index', 'App\Controllers\ProductsController');

        foreach ($products as $product) {
            $this->assertMatchesRegularExpression("/{$product->name}/", $response);
        }
    }
}
