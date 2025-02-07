<?php

namespace App\Models;

use Lib\Validations;
use Core\Database\ActiveRecord\Model;

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
        Validations::notEmpty('total', $this);
    }
}
