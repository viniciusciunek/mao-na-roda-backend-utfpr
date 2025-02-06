<?php

namespace App\Models;

use Lib\Paginator;
use Core\Database\Database;

class Budget
{
    /** @var array<string, string> */
    private array $errors = [];

    public function __construct(
        private int $id = -1,
        private int $customer_id = 0,
        private string $status = 'pending',
        private bool $cancelled = false,
        private bool $payed = false,
        private float $total = 0.0,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCustomerId(): int
    {
        return $this->customer_id;
    }

    public function setCustomerId(int $customer_id): void
    {
        $this->customer_id = $customer_id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function isCancelled(): bool
    {
        return $this->cancelled;
    }

    public function setCancelled(bool $cancelled): void
    {
        $this->cancelled = $cancelled;
    }

    public function isPayed(): bool
    {
        return $this->payed;
    }

    public function setPayed(bool $payed): void
    {
        $this->payed = $payed;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    public function save(): bool
    {
        if ($this->isValid()) {
            $pdo = Database::getDatabaseConn();

            if ($this->newRecord()) {
                $sql = 'INSERT INTO budgets (customer_id, status, cancelled, payed, total) VALUES
                    (:customer_id, :status, :cancelled, :payed, :total);';

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':customer_id', $this->customer_id);
                $stmt->bindParam(':status', $this->status);
                $stmt->bindParam(':cancelled', $this->cancelled, \PDO::PARAM_BOOL);
                $stmt->bindParam(':payed', $this->payed, \PDO::PARAM_BOOL);
                $stmt->bindValue(':total', $this->total);

                $stmt->execute();

                $this->id = (int) $pdo->lastInsertId();
            } else {
                $sql = 'UPDATE budgets SET customer_id = :customer_id, status = :status,
                    cancelled = :cancelled, payed = :payed, total = :total WHERE id = :id;';

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':customer_id', $this->customer_id);
                $stmt->bindParam(':status', $this->status);
                $stmt->bindParam(':cancelled', $this->cancelled, \PDO::PARAM_BOOL);
                $stmt->bindParam(':payed', $this->payed, \PDO::PARAM_BOOL);
                $stmt->bindValue(':total', $this->total);
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

        if (empty($this->customer_id)) {
            $this->errors['customer_id'] = 'Cliente não pode ser vazio!';
        }

        if (empty($this->total)) {
            $this->errors['total'] = 'Total não pode ser vazio!';
        }

        return empty($this->errors);
    }

    /**  @return array<int, Budget> */
    public static function all(): array
    {
        $budgets = [];

        $pdo = Database::getDatabaseConn();

        $resp = $pdo->query('SELECT * FROM budgets');

        foreach ($resp as $row) {
            $budgets[] = new Budget(
                id: (int) $row['id'],
                customer_id: $row['customer_id'],
                status: $row['status'],
                cancelled: $row['cancelled'],
                payed: $row['payed'],
                total: $row['total']
            );
        }

        return $budgets;
    }

    public static function findById(int $id): Budget|null
    {
        $pdo = Database::getDatabaseConn();
        $stmt = $pdo->prepare('SELECT * FROM budgets WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return null;
        }

        $row = $stmt->fetch();

        return new Budget(
            customer_id: $row['customer_id'],
            status: $row['status'],
            cancelled: $row['cancelled'],
            payed: $row['payed'],
            total: $row['total'],
            id: (int) $row['id'],
        );
    }

    public function destroy(): bool
    {
        $pdo = Database::getDatabaseConn();

        $sql = 'DELETE FROM budgets WHERE id = :id';

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
            Budget::class,
            $page,
            $per_page,
            'budgets',
            ['customer_id', 'status', 'cancelled', 'payed', 'total']
        );
    }
}
