<?php

namespace App\Models;

use Core\Database\Database;

class Product
{
    /** @var array<string, string> */
    private array $errors = [];

    public function __construct(
        private string $name = '',
        private string $description = '',
        private string $brand = '',
        private float $price = 0,
        private int $id = -1,
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function isValid(): bool
    {
        $this->errors = [];

        if (empty($this->name)) {
            $this->errors['name'] = 'Não pode ser vazio!';
        }

        if (empty($this->description)) {
            $this->errors['description'] = 'Insira uma descrição!';
        }

        if (empty($this->brand)) {
            $this->errors['brand'] = 'Insira a marca do produto!';
        }

        if (empty($this->price)) {
            $this->errors['price'] = 'Insira o preço do produto!';
        }

        return empty($this->errors);
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function errors(string $index = null): string|null
    {
        if (isset($this->errors[$index])) {
            return $this->errors[$index];
        }

        return null;
    }

    public function save(): bool
    {
        if ($this->isValid()) {
            $pdo = Database::getDatabaseConn();

            if ($this->newRecord()) {
                $sql = 'INSERT INTO products (name, description, brand, price) VALUES (:name, :description, :brand, :price)';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':description', $this->description);
                $stmt->bindParam(':brand', $this->brand);
                $stmt->bindParam(':price', $this->price);
                $stmt->execute();

                $this->id = (int) $pdo->lastInsertId();
            } else {
                $sql = 'UPDATE products SET name = :name, description = :description, brand = :brand, price = :price WHERE id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':description', $this->description);
                $stmt->bindParam(':brand', $this->brand);
                $stmt->bindParam(':price', $this->price);
                $stmt->bindParam(':id', $this->id);
                $stmt->execute();
            }
            return true;
        }
        return false;
    }

    /**
     * @return array<int, Product>
     */
    public static function all(): array
    {
        $products = [];

        $pdo = Database::getDatabaseConn();
        $resp = $pdo->query('SELECT * FROM products');

        foreach ($resp as $row) {
            $products[] = new Product(
                $row['name'],
                $row['description'],
                $row['brand'],
                (float) $row['price'],
                (int) $row['id'],
            );
        }

        return $products;
    }

    public static function findById(int $id): Product|null
    {
        $pdo = Database::getDatabaseConn();
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return null;
        }

        $row = $stmt->fetch();

        return new Product(
            $row['name'],
            $row['description'],
            $row['brand'],
            (float) $row['price'],
            (int) $row['id'],
        );
    }

    public function newRecord(): bool
    {
        return $this->id === -1;
    }

    public function destroy(): bool
    {
        $pdo = Database::getDatabaseConn();
        $sql = 'DELETE FROM products WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return ($stmt->rowCount() !== 0);
    }
}
