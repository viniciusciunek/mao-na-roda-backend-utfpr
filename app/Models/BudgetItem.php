<?php

namespace App\Models;

use Core\Database\Database;
use Lib\Paginator;

class BudgetItem
{
    /** @var array<string, string> */
    private array $errors = [];
    public function __construct(
        private int $budget_id = 0,
        private int $product_id = 0,
        private int $quantity = 0,
        private float $unit_price = 0.0,
        private float $total_price = 0.0,
        private int $id = -1,
    ) {
    }

    public function getBudgetId(): int
    {
        return $this->budget_id;
    }

    public function setBudgetId(int $budget_id): void
    {
        $this->budget_id = $budget_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getUnitPrice(): float
    {
        return $this->unit_price;
    }

    public function setUnitPrice(float $unit_price): void
    {
        $this->unit_price = $unit_price;
    }

    public function getTotalPrice(): float
    {
        return $this->total_price;
    }

    public function setTotalPrice(float $total_price): void
    {
        $this->total_price = $total_price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function save(): bool
    {
        if ($this->isValid()) {
            $pdo = Database::getDatabaseConn();

            if ($this->newRecord()) {
                $sql = 'INSERT INTO budget_items (budget_id, product_id, quantity, unit_price, total_price)
                            VALUES (:budget_id, :product_id, :quantity, :unit_price, :total_price)';

                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':budget_id', $this->budget_id);
                $stmt->bindParam(':product_id', $this->product_id);
                $stmt->bindParam(':quantity', $this->quantity);
                $stmt->bindParam(':unit_price', $this->unit_price);
                $stmt->bindParam(':total_price', $this->total_price);

                $stmt->execute();

                $this->id = (int) $pdo->lastInsertId();
            } else {
                $sql = 'UPDATE budget_items SET
                            budget_id = :budget_id,
                            product_id = :product_id,
                            quantity = :quantity,
                            unit_price = :unit_price,
                            total_price = :total_price
                            WHERE id = :id;';

                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':budget_id', $this->budget_id);
                $stmt->bindParam(':product_id', $this->product_id);
                $stmt->bindParam(':quantity', $this->quantity);
                $stmt->bindParam(':unit_price', $this->unit_price);
                $stmt->bindParam(':total_price', $this->total_price);

                $stmt->bindParam(':id', $this->id);
                $stmt->execute();
            }

            return true;
        }

        return false;
    }

    public function newRecord(): bool
    {
        return $this->id === -1;
    }

    public function isValid(): bool
    {
        $this->errors = [];

        if (empty($this->budget_id)) {
            $this->errors['budget_id'] = 'budget_id não pode ser vazio!';
        }

        if (empty($this->product_id)) {
            $this->errors['product_id'] = 'product_id não pode ser vazio!';
        }

        if (empty($this->quantity)) {
            $this->errors['quantity'] = 'quantity não pode ser vazio!';
        }

        if (empty($this->unit_price)) {
            $this->errors['unit_price'] = 'unit_price não pode ser vazio!';
        }

        if (empty($this->total_price)) {
            $this->errors['total_price'] = 'total_price não pode ser vazio!';
        }

        return empty($this->errors);
    }

    /**  @return array<int, BudgetItem> */
    public static function all(): array
    {
        $budgetsItems = [];

        $pdo = Database::getDatabaseConn();

        $resp = $pdo->query('SELECT * FROM budget_items');

        foreach ($resp as $row) {
            $budgetsItems[] = new BudgetItem(
                $row[':budget_id'],
                $row[':product_id'],
                $row[':quantity'],
                $row[':total_price'],
                $row[':unit_price']
            );
        }

        return $budgetsItems;
    }

    public static function findById(int $id): BudgetItem|null
    {
        $pdo = Database::getDatabaseConn();

        $stmt = $pdo->prepare('SELECT * FROM budget_items WHERE id = :id');

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return null;
        }

        $row = $stmt->fetch();

        return new BudgetItem(
            $row[':budget_id'],
            $row[':product_id'],
            $row[':quantity'],
            $row[':total_price'],
            $row[':unit_price']
        );
    }

    public function destroy(): bool
    {
        $pdo = Database::getDatabaseConn();

        $sql = 'DELETE FROM budget_items WHERE id = :id';

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        return ($stmt->rowCount() !== 0);
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

    public static function paginate(int $page = 1, int $per_page = 10): Paginator
    {
        return new Paginator(
            BudgetItem::class,
            $page,
            $per_page,
            'budget_items',
            ['budget_id', 'product_id', 'quantity', 'unit_price', 'total_price']
        );
    }
}
