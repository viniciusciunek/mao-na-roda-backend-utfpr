<?php

namespace Tests\Unit\Controllers;

use App\Models\Product;

class ProductsControllerTest extends BaseControllerTestCase
{
    public function test_list_all_products()
    {
        $products[] = new Product('Product 1', 'Product 1', 'Product 1', 1);
        $products[] = new Product('Product 2', 'Product 2', 'Product 2', 2);

        foreach ($products as $product) {
            $product->save();
        }

        $response = $this->get('index', 'App\Controllers\ProductsController');

        foreach ($products as $product) {
            $this->assertMatchesRegularExpression("/{$product->getName()}/", $response);
        }
    }
}
