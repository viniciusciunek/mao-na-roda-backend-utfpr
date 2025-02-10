<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use Core\Http\Controllers\Controller;
use Core\Http\Request;
use Lib\Authentication\Auth;
use Lib\FlashMessage;

class AuthenticationsController extends Controller
{
    protected string $layout = 'login';

    public function new(): void
    {
        $this->render('authentications/new');
    }

    public function authenticate(Request $request): void
    {
        $params = $request->getParam('user');

        $user = Customer::findByEmail($params['email']) ?? Admin::findByEmail($params['email']);

        if ($user && $user->authenticate($params['password'])) {
            Auth::login($user);

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
}
