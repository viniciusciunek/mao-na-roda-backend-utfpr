<?php

namespace App\Models;

use Core\Database\ActiveRecord\HasMany;
use Lib\Validations;
use Core\Database\ActiveRecord\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $encrypted_password
 * @property string $phone
 * @property string $cpf
 * @property string $cnpj
 */
class Customer extends Model
{
    protected static string $table = 'customers';
    protected static array $columns = ['name', 'email', 'encrypted_password', 'phone', 'cpf', 'cnpj'];

    protected ?string $password = null;
    protected ?string $password_confirmation = null;

    public function validates(): void
    {
        Validations::notEmpty('name', $this);
        Validations::notEmpty('email', $this);
        Validations::notEmpty('phone', $this);

        Validations::uniqueness('email', object: $this);

        if ($this->newRecord()) {
            Validations::passwordConfirmation($this);
        }
    }

    public function __set(string $property, mixed $value): void
    {
        parent::__set($property, $value);

        if (
            $property === 'password' &&
            $this->newRecord() &&
            $value !== null && $value !== ''
        ) {
            $this->encrypted_password = password_hash($value, PASSWORD_DEFAULT);
        }
    }

    public function authenticate(string $password): bool
    {
        if ($this->encrypted_password == null) {
            return false;
        }

        return password_verify($password, $this->encrypted_password);
    }

    public static function findByEmail(string $email): Customer | null
    {
        return Customer::findBy(['email' => $email]);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class, 'customer_id');
    }
}
