<?php

namespace App\Middleware;

use App\Models\Customer;
use Core\Http\Middleware\Middleware;
use Core\Http\Request;
use Lib\Authentication\Auth;
use Lib\FlashMessage;

class CustomerMiddleware implements Middleware
{
    public function handle(Request $request): void
    {
        $user = Auth::user();

        if (!$user instanceof Customer) {
            FlashMessage::danger('Acesso restrito a clientes');

            $this->redirectTo(route('login'));
        }
    }

    private function redirectTo(string $location): void
    {
        header('Location: ' . $location);
        exit;
    }
}
