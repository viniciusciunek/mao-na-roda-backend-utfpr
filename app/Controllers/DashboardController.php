<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Admin;
use Core\Http\Request;
use Lib\Authentication\Auth;
use Lib\FlashMessage;

class DashboardController
{
    private string $layout = 'application';

    private User|Admin|null $currentUser = null;

    public function isAdmin(): bool
    {
        return Auth::user() instanceof Admin;
    }

    public function currentUser(): User|Admin|null
    {
        if ($this->currentUser === null && isset($_SESSION['user']['id'])) {
            $this->currentUser = Auth::user();
        }

        return $this->currentUser;
    }

    public function index(Request $request)
    {
        $title = 'Dashboard';

        $this->render('index', compact('title'));
    }

    /**
     * @param array<string, mixed> $data
     */
    private function render(string $view, array $data = []): void
    {
        extract($data);

        $view = '/var/www/app/views/dashboard/' . $view . '.phtml';
        require '/var/www/app/views/layouts/' . $this->layout . '.phtml';
    }

    private function redirectTo(string $location): void
    {
        header('Location: ' . $location);
        exit;
    }
}
