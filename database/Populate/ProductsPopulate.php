<?php

namespace Database\Populate;

use App\Models\Product;

class ProductsPopulate
{
    public static function populate()
    {
        $numberOfProducts = 100;

        for ($i = 0; $i < $numberOfProducts; $i++) {
            $product = new Product('Product ' . $i, 'Description ' . $i, 'Brand ' . $i, 100 + $i);
            $product->save();
        }

        echo $numberOfProducts . ' products populated!' . PHP_EOL;
    }
}
