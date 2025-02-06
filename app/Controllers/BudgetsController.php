<?php

namespace App\Controllers;

use App\Models\Admin;
use Lib\FlashMessage;
use App\Models\Budget;
use App\Models\BudgetItem;
use Core\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use Lib\Authentication\Auth;

class BudgetsController
{
    private string $layout = 'application';

    private Customer|Admin|null $currentUser = null;

    public function isAdmin(): bool
    {
        return Auth::user() instanceof Admin;
    }

    public function currentUser(): Customer|Admin|null
    {
        if ($this->currentUser === null && isset($_SESSION['user']['id'])) {
            $this->currentUser = Auth::user();
        }

        return $this->currentUser;
    }

    public function index(Request $request): void
    {
        $paginator = Budget::paginate(page: $request->getParam('page', 1));

        $budgets = $paginator->registers();

        $title = 'Orçamentos Registrados';

        if ($request->acceptJson()) {
            $this->renderJson('index', compact('paginator', 'budgets', 'title'));
        } else {
            $this->render('index', compact('paginator', 'budgets', 'title'));
        }
    }

    public function show(Request $request): void
    {
        $params = $request->getParams();

        $budget = Budget::findById($params['id']);

        $title = "Visualização do Orçamento #{$budget->getId()}";

        $this->render('show', compact('budget', 'title'));
    }

    public function new(): void
    {
        $budget = new Budget();

        $customers = Customer::all();

        $products = Product::all();

        $title = 'Criando Orçamento';

        $this->render('new', compact('budget', 'customers', 'products', 'title'));
    }


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

            $this->render('new', compact('budget', 'customers', 'products', 'title'));

            return false;
        }

        $total = 0.0;

        foreach ($products as $product) {
            $total += $product['price'] * $product['quantity'];
        }

        $budget = new Budget(
            customer_id: $budgetData['customer_id'],
            status: $budgetData['status'] ?? 'pending',
            cancelled: $budgetData['cancelled'] ?? false,
            payed: $budgetData['payed'] ?? false,
            total: $total,
        );


        if ($budget->save()) {
            foreach ($products as $product) {
                $budgetItem = new BudgetItem(
                    budget_id: (int) $budget->getId(),
                    product_id: $product['id'],
                    quantity: $product['quantity'],
                    unit_price: $product['price'],
                    total_price: $product['price'] * $product['quantity'],
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

            $this->render('new', compact('budget', 'customers', 'products', 'title'));
        }

        return true;
    }

    /** @param array<string, mixed> $data */

    private function render(string $view, array $data = []): void
    {
        extract($data);

        $view = '/var/www/app/views/budgets/' . $view . '.phtml';
        require '/var/www/app/views/layouts/' . $this->layout . '.phtml';
    }


    /** @param array<string, mixed> $data */
    private function renderJson(string $view, array $data = []): void
    {
        extract($data);

        $view = '/var/www/app/views/budgets/' . $view . '.json.php';
        $json = [];

        header('Content-Type: application/json; chartset=utf-8');
        require $view;
        echo json_encode($json);
        return;
    }

    private function redirectTo(string $location): void
    {
        header('Location: ' . $location);
        exit;
    }
}
