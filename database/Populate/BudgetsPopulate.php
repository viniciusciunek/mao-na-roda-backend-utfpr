<?php

namespace Database\Populate;

use App\Models\Budget;

class BudgetsPopulate
{
    public static function populate()
    {
        $numberOfBudgets = 10;

        for ($i = 1; $i < $numberOfBudgets; $i++) {
            $budget = new Budget(
                [
                    'customer_id' => 1,
                    'status' => 'pending_approve',
                    'cancelled' => 0,
                    'payed' => 0,
                    'total' => $i * 100
                ]
            );

            $budget->save();
        }

        for ($i = 1; $i < $numberOfBudgets; $i++) {
            $budget = new Budget(
                [
                    'customer_id' => 2,
                    'status' => 'pending_approve',
                    'cancelled' => 0,
                    'payed' => 0,
                    'total' => $i * 100
                ]
            );

            $budget->save();
        }


        echo "Budgets populated with $numberOfBudgets registers\n";
    }
}
