<?php

namespace App\Middleware;

use App\Models\Admin;
use Core\Http\Middleware\Middleware;
use Core\Http\Request;
use Lib\Authentication\Auth;
use Lib\FlashMessage;

class AdminMiddleware implements Middleware
{
    public function handle(Request $request): void
    {
        $user = Auth::user();

        if (!$user instanceof Admin) {
            FlashMessage::danger('Acesso restrito a administradores');
            $this->redirectTo(route('login'));
        }
    }

    private function redirectTo(string $location): void
    {
        header('Location: ' . $location);
        exit;
    }
}
