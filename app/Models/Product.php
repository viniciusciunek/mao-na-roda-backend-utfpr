<?php

namespace App\Models;

use Core\Constants\Constants;
use Core\Constants\StringPath;

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
            if ($this->newRecord()) {
                $this->id = file_exists(self::dbPath()) ? count(file(self::dbPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)) : 0;
                file_put_contents(self::dbPath(), "$this->name | $this->description | $this->brand | $this->price" . PHP_EOL, FILE_APPEND);
            } else {
                $products = file(self::dbPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $products[$this->id] = "$this->name | $this->description | $this->brand | $this->price";

                $data = implode(PHP_EOL, $products);
                file_put_contents(self::dbPath(), $data . PHP_EOL);
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
        if (!file_exists(self::dbPath())) {
            return [];
        }

        $products = file(self::dbPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (count($products) == 0) {
            return [];
        }

        return array_map(function ($line, $data) {
            $name = explode("|", $data)[0];
            $description = explode("|", $data)[1];
            $brand = explode("|", $data)[2];
            $price = (float) explode("|", $data)[3];

            return new Product($name, $description, $brand, $price, $line);
        }, array_keys($products), $products);
    }

    public static function findById(int $id): Product|null
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
        $products = file(self::dbPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        unset($products[$this->id]);

        $data = implode(PHP_EOL, $products);
        file_put_contents(self::dbPath(), $data . PHP_EOL);
    }

    private static function dbPath(): StringPath
    {
        return Constants::databasePath()->join($_ENV['DB_NAME']);
    }
}
