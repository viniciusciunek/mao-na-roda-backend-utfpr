<?php

namespace App\Controllers;

use Lib\FlashMessage;
use App\Models\Budget;
use Core\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\BudgetItem;
use Core\Exceptions\HTTPException;
use Core\Http\Controllers\Controller;
use Exception;

class BudgetsController extends Controller
{
    public function index(Request $request): void
    {
        if ($this->isAdmin()) {
            $paginator = Budget::paginate(page: $request->getParam('page', 1));
        } else {
            $paginator = $this->currentUser()->budgets()->paginate(page: $request->getParam('page', 1));
        }

        $budgets = $paginator->registers();

        $title = 'Orçamentos Registrados';

        if ($request->acceptJson()) {
            $this->renderJson('budgets/index', compact('paginator', 'budgets', 'title'));
        } else {
            $this->render('budgets/index', compact('paginator', 'budgets', 'title'));
        }
    }

    public function show(Request $request): void
    {
        $params = $request->getParams();

        if ($this->isAdmin()) {
            $budget = Budget::findById((int) $params['id']);
        } else {
            $budget = $this->currentUser()->budgets()->findById((int) $params['id']);
        }

        $title = "Visualização do Orçamento #{$budget->id}";

        $this->render('budgets/show', compact('budget', 'title'));
    }

    public function new(): void
    {
        if ($this->isAdmin()) {
            $budget = new Budget();
        } else {
            $budget = $this->currentUser()->budgets()->new();
        }

        $customers = Customer::all();

        $products = Product::all();

        $title = 'Criando Orçamento';

        $this->render('budgets/new', compact('budget', 'customers', 'products', 'title'));
    }

    public function create(Request $request): void
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['customer_id'])) {
                throw new HTTPException('Selecione um cliente', 400);
            }

            $budget = new Budget([
                'customer_id' => (int) $data['customer_id'],
                'status' => 'draft',
                'total' => 0.00,
                'cancelled' => 0,
                'payed' => 0
            ]);

            if ($budget->save()) {
                $this->jsonResponse([
                    'success' => true,
                    'budget_id' => $budget->id,
                    'message' => 'Orçamento criado. Adicione os produtos'
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'budget_id' => $budget->id,
                    'message' => $budget->errors('payed')
                ]);

                throw new HTTPException('Erro ao criar orçamento', 500);
            }
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function edit(Request $request): void
    {
        $budgetId = $request->getParams()['id'];

        $budget = Budget::findById((int) $budgetId);

        $budget->customer();

        $customers = Customer::all();
        $products = Product::all();

        $title = 'Editar orçamento';

        $this->render('budgets/edit', compact('budget', 'customers', 'products', 'title'));
    }

    public function changeStatus(): void
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            $status = $data['status'];

            $budget = Budget::findById($data['budget_id']);

            $budget->update([
                'status' => $status
            ]);

            $this->jsonResponse([
                'success' => true,
                'message' => 'Status alterado para: ' . $status
            ]);
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
