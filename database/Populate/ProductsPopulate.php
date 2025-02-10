<?php

namespace Database\Populate;

use App\Models\Product;

class ProductsPopulate
{
    public static function populate()
    {
        $numberOfProducts = 100;

        for ($i = 0; $i < $numberOfProducts; $i++) {
            $product = new Product(
                [
                    'name' => 'Product ' . $i,
                    'description' => 'Description ' . $i,
                    'brand' => 'Brand ' . $i,
                    'price' => 100 + $i
                ]
            );
            $product->save();
        }

        echo $numberOfProducts . ' products populated!' . PHP_EOL;
    }
}
