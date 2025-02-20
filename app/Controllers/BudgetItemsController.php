<?php

namespace App\Controllers;

use App\Models\BudgetItem;
use Core\Http\Request;
use Core\Http\Controllers\Controller;
use Exception;

class BudgetItemsController extends Controller
{
    public function create(): void
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            $total = $data['quantity'] * $data['price'];

            $budgetItem = new BudgetItem([
                'budget_id' => $data['budget_id'],
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'unit_price' => $data['price'],
                'total_price' => $total
            ]);

            if ($budgetItem->save()) {
                $this->jsonResponse([
                    'status' => 'success',
                    'message' => 'Item adicionado ao orçamento com sucesso',
                    'data' => $budgetItem
                ]);
            } else {
                $this->jsonResponse([
                    'status' => 'error',
                    'message' => 'Erro ao adicionar item ao orçamento',
                    'data' => $budgetItem
                ]);
            }
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function destroy(): void
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            $budgetItem = BudgetItem::findById((int) $data['id']);

            if ($budgetItem->destroy()) {
                $this->jsonResponse([
                    'status' => 'success',
                    'message' => 'Item removido do orçamento com sucesso'
                ]);
            } else {
                $this->jsonResponse([
                    'status' => 'error',
                    'message' => 'Erro ao remover item do orçamento'
                ]);
            }
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
