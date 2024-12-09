<?php

namespace App\Controllers;

use App\Models\Admin;
use Lib\FlashMessage;
use App\Models\Budget;
use Core\Http\Request;
use App\Models\Customer;
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

    public function new(): void
    {
        $budget = new Budget();

        $customers = Customer::all();

        $title = 'Criando Orçamento';

        $this->render('new', compact('budget', 'customers', 'title'));
    }

    public function create(Request $request): bool
    {
        $params = $request->getParams()['budget'];

        $params = array_map('trim', $params);

        $budget = new Budget(
            customer_id: $params['customer_id'],
            status: $params['status'] ?? 'pending',
            cancelled: $params['cancelled'] ?? 0,
            payed: $params['payed'] ?? 0,
            total: $params['total'] ?? 0,
        );

        dd($budget);

        if ($budget->save()) {
            FlashMessage::success("Orçamento criado com sucesso!");

            $this->redirectTo(route('budgets.index'));
        } else {
            FlashMessage::danger("Erro ao criar orçamento!");

            $title = 'Novo Orçamento';

            $this->render('new', compact('budget', 'title'));
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
