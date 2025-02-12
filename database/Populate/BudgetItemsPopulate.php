<?php

namespace Database\Populate;

use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\Product;

class BudgetItemsPopulate
{
    public static function populate()
    {
        $budgets = Budget::all();

        $products = Product::all();

        $maxIndex = count($products) - 1;

        foreach ($budgets as $budget) {
            $numItems = rand(1, 5);

            for ($i = 0; $i < $numItems; $i++) {
                $randomIndex = rand(0, $maxIndex);
                $prod = $products[$randomIndex];

                $quantity   = rand(1, 5);
                $unit_price = $prod->price;
                $total_price = $quantity * $unit_price;

                $budgetItem = new BudgetItem([
                    'budget_id'   => $budget->id,
                    'product_id'  => $prod->id,
                    'quantity'    => $quantity,
                    'unit_price'  => $unit_price,
                    'total_price' => $total_price
                ]);

                $budgetItem->save();
            }
        }

        echo "Budget Items populated with 1-5 items por Budget\n";
    }
}
