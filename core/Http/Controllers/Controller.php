<?php

namespace Core\Http\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use Lib\Authentication\Auth;
use Core\Constants\Constants;

class Controller
{
    protected string $layout = 'application';

    private Customer|Admin|null $current_user = null;

    public function __construct()
    {
        $this->current_user = Auth::user();
    }

    public function isAdmin(): bool
    {
        return Auth::user() instanceof Admin;
    }

    public function currentUser(): Customer|Admin|null
    {
        if ($this->current_user === null && isset($_SESSION['user']['id'])) {
            $this->current_user = Auth::user();
        }

        return $this->current_user;
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

    protected function redirectBack(): void
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';

        $this->redirectTo($referer);
    }

    /**
     * @param array<mixed> $data
     */
    protected function jsonResponse(array $data, int $status = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
}
