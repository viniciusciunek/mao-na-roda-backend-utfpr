<?php

class Product
{
  const DB_PATH = '/var/www/database/products.txt';

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
      $this->id = count(file(self::DB_PATH));
      file_put_contents(self::DB_PATH, "$this->name | $this->description | $this->brand | $this->price" . PHP_EOL, FILE_APPEND);
      return true;
    }

    return false;
  }
}
