<?php

namespace App\Controllers;

use Lib\FlashMessage;
use App\Models\Budget;
use Core\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\BudgetItem;
use Core\Http\Controllers\Controller;

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
            $budget = Budget::findById($params['id']);
        } else {
            $budget = $this->currentUser()->budgets()->findById($params['id']);
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

    // public function edit(Request $request): void
    // {
    //     $params = $request->getParams();

    //     $budget = Budget::findById($params['id']);

    //     $title = "Editar Orçamento #{$budget->id}";

    //     $this->render('products/edit', compact('product', 'title'));
    // }

    public function create(Request $request): bool
    {
        $params = $request->getParams();

        $budgetData = $params['budget'];

        $products = json_decode($params['products'], true);

        if (empty($products)) {
            FlashMessage::danger("Adicione pelo menos um produto ao orçamento.");

            $budget = new Budget();

            $customers = Customer::all();

            $products = Product::all();

            $title = 'Criando Orçamento';

            $this->render('budgets/new', compact('budget', 'customers', 'products', 'title'));

            return false;
        }

        $total = 0.0;

        foreach ($products as $product) {
            $total += $product['price'] * $product['quantity'];
        }

        $budget = new Budget(
            [
                'customer_id' =>  $budgetData['customer_id'],
                'status' => $budgetData['status'] ?? 'pending',
                'cancelled' => $budgetData['cancelled'] ?? false,
                'payed' => $budgetData['payed'] ?? false,
                'total' => $total
            ]
        );


        if ($budget->save()) {
            foreach ($products as $product) {
                $budgetItem = new BudgetItem(
                    [
                        'budget_id' => (int) $budget->id,
                        'product_id' => $product['id'],
                        'quantity' => $product['quantity'],
                        'unit_price' => $product['price'],
                        'total_price' => $product['price'] * $product['quantity']
                    ]
                );
                $budgetItem->save();
            }

            FlashMessage::success("Orçamento criado com sucesso!");

            $this->redirectTo(route('budgets.index'));
        } else {
            FlashMessage::danger("Erro ao criar orçamento!");

            $budget = new Budget();

            $customers = Customer::all();

            $products = Product::all();

            $title = 'Criando Orçamento';

            $this->render('budgets/new', compact('budget', 'customers', 'products', 'title'));
        }

        return true;
    }
}
