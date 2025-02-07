<?php

namespace App\Models;

use Lib\Validations;
use Core\Database\ActiveRecord\Model;

class Admin extends Model
{
    protected static string $table = 'admins';
    protected static array $columns = ['name', 'email', 'encrypted_password'];

    protected ?string $password = null;
    protected ?string $password_confirmation = null;


    public function validates(): void
    {
        Validations::notEmpty('name', $this);
        Validations::notEmpty('email', $this);

        Validations::uniqueness('email', $this);

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

    public static function findByEmail(string $email): Admin | null
    {
        return Admin::findBy(['email' => $email]);
    }
}
