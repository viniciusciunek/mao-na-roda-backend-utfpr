<?php

namespace App\Models;

use Core\Database\ActiveRecord\BelongsTo;
use Lib\Validations;
use Core\Database\ActiveRecord\Model;

/**
 * @property int $id
 * @property int $budget_id
 * @property int $product_id
 * @property int $quantity
 * @property float $unit_price
 * @property float $total_price
 */

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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
