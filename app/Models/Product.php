<?php

namespace App\Models;

use Lib\Validations;
use Core\Database\ActiveRecord\Model;
use Core\Database\ActiveRecord\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $brand
 * @property float $price
 */
class Product extends Model
{
    protected static string $table = 'products';

    protected static array $columns = ['name', 'description', 'brand', 'price', 'active'];

    public function validates(): void
    {
        Validations::notEmpty('name', $this);
        Validations::notEmpty('description', $this);
        Validations::notEmpty('brand', $this);
        Validations::notEmpty('price', $this);
    }

    public function budgets(): BelongsToMany
    {
        return $this->belongsToMany(
            Budget::class,
            'budget_items',
            'product_id',
            'budget_id'
        );
    }
}
