<?php

namespace Core\Http\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use Lib\Authentication\Auth;
use Core\Constants\Constants;

class Controller
{
    protected string $layout = 'application';

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

    /**
     * @param array<string, mixed> $data
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);

        $view = Constants::rootPath()->join('app/views/' . $view . '.phtml');
        require Constants::rootPath()->join('app/views/layouts/' . $this->layout . '.phtml');
    }


    /**
     * @param array<string, mixed> $data
     */
    protected function renderJson(string $view, array $data = []): void
    {
        extract($data);

        $view = Constants::rootPath()->join('app/views/' . $view . '.json.php');
        $json = [];

        header('Content-Type: application/json; chartset=utf-8');
        require $view;
        echo json_encode($json);
        return;
    }

    protected function redirectTo(string $location): void
    {
        header('Location: ' . $location);
        exit;
    }
}
