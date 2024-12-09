<?php

namespace Lib\Authentication;

use App\Models\Admin;
use App\Models\Customer;

class Auth
{
    public static function login(Customer|Admin $customer): void
    {
        $_SESSION['user']['id'] = $customer->getId();
        $_SESSION['user']['email'] = $customer->getEmail();
    }

    public static function logout(): void
    {
        unset($_SESSION['user']['id']);
    }


    public static function user(): Customer|Admin|null
    {
        if (isset($_SESSION['user']['id'])) {
            $id = $_SESSION['user']['id'];
            $email = $_SESSION['user']['email'];

            if (Admin::findById($id) !== null && Admin::findByEmail($email) !== null) {
                return Admin::findById($id);
            }

            return Customer::findById($id);
        }

        return null;
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']['id']) && self::user() !== null;
    }
}
