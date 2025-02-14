<?php

namespace Database\Populate;

use App\Models\Budget;

class BudgetsPopulate
{
    public static function populate()
    {
        $statuses = ['pending_approve', 'approved', 'reproved', 'completed'];
        $numberOfBudgets = 15;

        for ($i = 1; $i <= $numberOfBudgets; $i++) {
            $randomCustomerId = rand(1, 10);
            $randomStatus = $statuses[array_rand($statuses)];
            $cancelled = (int) (rand(0, 10) < 2);
            $payed     = (int) (rand(0, 10) < 4);
            $total     = rand(100, 1000);

            $budget = new Budget([
                'customer_id' => $randomCustomerId,
                'status'      => $randomStatus,
                'cancelled'   => $cancelled,
                'payed'       => $payed,
                'total'       => $total,
            ]);
            $budget->save();
        }

        echo "Budgets populated with {$numberOfBudgets} registers\n";
    }
}
