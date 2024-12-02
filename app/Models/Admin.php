<?php

namespace App\Models;

use Core\Database\Database;

class Admin
{
    /** @var array<string, string> */
    private array $errors = [];

    public function __construct(
        private int $id = -1,
        private string|null $name = null,
        private string|null $email = null,
        private string|null $password = null,
        private string|null $password_confirmation = null,
    ) {}

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string | null
    {
        return $this->name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string | null
    {
        return $this->email;
    }


    public function save(): bool
    {
        if ($this->isValid()) {
            $pdo = Database::getDatabaseConn();
            if ($this->newRecord()) {
                $sql = 'INSERT INTO admins (name, email, password)
                    VALUES (:name, :email, :password);';

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':email', $this->email);

                $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $password_hash);

                $stmt->execute();

                $this->id = (int) $pdo->lastInsertId();
            } else {
                $sql = 'UPDATE admins SET name = :name, email = :email WHERE id = :id;';

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':id', $this->id);

                $stmt->execute();
            }
            return true;
        }
        return false;
    }


    public function isValid(): bool
    {
        $this->errors = [];

        if (empty($this->name)) {
            $this->errors['name'] = 'não pode ser vazio!';
        }

        if (empty($this->email)) {
            $this->errors['email'] = 'não pode ser vazio!';
        }

        if (empty($this->password)) {
            $this->errors['password'] = 'não pode ser vazio!';
        }

        if ($this->password !== $this->password_confirmation) {
            $this->errors['password'] = 'as senhas devem ser idênticas!';
        }

        return empty($this->errors);
    }

    public function newRecord(): bool
    {
        return $this->id === -1;
    }

    public function hasErrors(): bool
    {
        return empty($this->errors);
    }

    public function errors(string $index): string | null
    {
        if (isset($this->errors[$index])) {
            return $this->errors[$index];
        }

        return null;
    }

    public function authenticate(string $password): bool
    {
        $pdo = Database::getDatabaseConn();

        $sql = 'SELECT password FROM admins WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $this->email);

        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return false;
        }

        $row = $stmt->fetch();

        return password_verify($password, $row['password']);
    }

    public function destroy(): bool
    {
        $pdo = Database::getDatabaseConn();

        $sql = 'DELETE FROM admins WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        return ($stmt->rowCount() !== 0);
    }

    /**
     * @return array<int, Admin>
     */
    public static function all(): array
    {
        $admins = [];

        $pdo = Database::getDatabaseConn();
        $resp = $pdo->query('SELECT id, name, email FROM admins;');

        foreach ($resp as $row) {
            $admins[] = new Admin(
                id: $row['id'],
                name: $row['name'],
                email: $row['email'],
            );
        }

        return $admins;
    }

    public static function findById(int $id): Admin|null
    {
        $pdo = Database::getDatabaseConn();

        $sql = 'SELECT id, name, email FROM admins WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return null;
        }

        $row = $stmt->fetch();

        return new Admin(
            id: $row['id'],
            name: $row['name'],
            email: $row['email'],
        );
    }

    public static function findByEmail(string $email): Admin | null
    {
        $pdo = Database::getDatabaseConn();

        $sql = 'SELECT id, name, email
            FROM admins WHERE email = :email';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return null;
        }

        $row = $stmt->fetch();

        return new Admin(
            id: $row['id'],
            name: $row['name'],
            email: $row['email'],
        );
    }
}
