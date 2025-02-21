<?php

namespace App\Models;

use Core\Database\ActiveRecord\BelongsTo;
use Core\Database\ActiveRecord\BelongsToMany;
use Core\Database\ActiveRecord\HasMany;
use Lib\Validations;
use Core\Database\ActiveRecord\Model;

/**
 * @property int $id
 * @property int $customer_id
 * @property string $status
 * @property boolean $cancelled
 * @property boolean $payed
 * @property float $total
 *
 */
class Budget extends Model
{
    protected static string $table = 'budgets';
    protected static array $columns = ['customer_id', 'status', 'cancelled', 'payed', 'total'];

    public function validates(): void
    {
        Validations::notEmpty('customer_id', $this);
        Validations::notEmpty('status', $this);
        Validations::notEmpty('cancelled', $this);
        Validations::notEmpty('payed', $this);
        // Validations::nonZero('total', $this);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'budget_items',
            'budget_id',
            'product_id'
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(BudgetItem::class, 'budget_id');
    }
}
