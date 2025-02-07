<?php

namespace App\Models;

use Lib\Validations;
use Core\Database\ActiveRecord\Model;

class BudgetItem extends Model
{
    protected static string $table = 'budget_items';

    protected static array $columns = ['budget_id', 'product_id', 'quantity', 'unit_price', 'total_price'];

    public function validates(): void
    {
        Validations::notEmpty('budget_id', $this);
        Validations::notEmpty('product_id', $this);
        Validations::notEmpty('quantity', $this);
        Validations::notEmpty('unit_price', $this);
        Validations::notEmpty('total_price', $this);
    }
}
