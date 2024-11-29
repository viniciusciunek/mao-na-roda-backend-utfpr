<?php

namespace App\Models;

class Product
{
    private array $errors = [];

    public function __construct(
        private string $name = '',
        private string $description = '',
        private string $brand = '',
        private float $price = 0,
        private int $id = -1,
    ) {
    }

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

    public function errors($index = null)
    {
        if (isset($this->errors[$index])) {
            return $this->errors[$index];
        }

        return null;
    }

    public function save(): bool
    {
        if ($this->isValid()) {
            if ($this->newRecord()) {
                $this->id = file_exists(self::DB_PATH()) ? count(file(self::DB_PATH())) : 0;
                file_put_contents(self::DB_PATH(), "$this->name | $this->description | $this->brand | $this->price" . PHP_EOL, FILE_APPEND);
            } else {
                $products = file(self::DB_PATH(), FILE_IGNORE_NEW_LINES);
                $products[$this->id] = "$this->name | $this->description | $this->brand | $this->price";

                $data = implode(PHP_EOL, $products);
                file_put_contents(self::DB_PATH(), $data . PHP_EOL);
            }
            return true;
        }
        return false;
    }

    public static function all(): array
    {
        if (!file_exists(self::DB_PATH())) {
            return [];
        }

        $products = file(self::DB_PATH(), FILE_IGNORE_NEW_LINES);

        return array_map(function ($line, $data) {
            $name = explode("|", $data)[0];
            $description = explode("|", $data)[1];
            $brand = explode("|", $data)[2];
            $price = explode("|", $data)[3];

            return new Product($name, $description, $brand, $price, $line);
        }, array_keys($products), $products);
    }

    public static function findById($id): Product|null
    {
        $products = self::all();

        foreach ($products as $product) {
            if ($product->getId() === (int) $id) {
                return $product;
            }
        }

        return null;
    }

    public function newRecord(): bool
    {
        return $this->id === -1;
    }

    public function destroy(): void
    {
        $products = file(self::DB_PATH(), FILE_IGNORE_NEW_LINES);
        unset($products[$this->id]);

        $data = implode(PHP_EOL, $products);
        file_put_contents(self::DB_PATH(), $data . PHP_EOL);
    }

    private static function DB_PATH()
    {
        return DATABASE_PATH . $_ENV['DB_NAME'];
    }
}
