<?php

namespace App\Models;

use Lib\Validations;
use Core\Database\ActiveRecord\Model;

class Product extends Model
{
    protected static string $table = 'products';

    protected static array $columns = ['name', 'description', 'brand', 'price'];

    public function validates(): void
    {
        Validations::notEmpty('name', $this);
        Validations::notEmpty('description', $this);
        Validations::notEmpty('brand', $this);
        Validations::notEmpty('price', $this);
    }
}
