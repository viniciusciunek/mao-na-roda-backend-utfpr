<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use Core\Http\Request;
use Lib\Authentication\Auth;
use Lib\FlashMessage;

class AuthenticationsController
{
    private string $layout = 'login';

    public function new(): void
    {
        $this->render('new');
    }

    public function authenticate(Request $request): void
    {
        $params = $request->getParam('user');

        $customer = Customer::findByEmail($params['email']) ?? Admin::findByEmail($params['email']);

        if ($customer && $customer->authenticate($params['password'])) {
            Auth::login($customer);

            FlashMessage::success('Login realizado com sucesso!');

            $this->redirectTo(route('root'));
        } else {
            FlashMessage::danger('Email e/ou senha inválidos!');

            $this->redirectTo(route('customers.login'));
        }
    }

    public function destroy(): void
    {
        Auth::logout();

        FlashMessage::success('Logout realizado com sucesso!');

        $this->redirectTo(route('customers.login'));
    }


    /**
     * @param array<string, mixed> $data
     */
    private function render(string $view, array $data = []): void
    {
        extract($data);

        $view = '/var/www/app/views/authentications/' . $view . '.phtml';
        require '/var/www/app/views/layouts/' . $this->layout . '.phtml';
    }

    private function redirectTo(string $location): void
    {
        header('Location: ' . $location);
        exit;
    }
}
