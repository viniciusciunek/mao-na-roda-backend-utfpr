<?php

namespace Lib\Authentication;

use App\Models\Admin;
use App\Models\User;

class Auth
{
    public static function login(User|Admin $user): void
    {
        $_SESSION['user']['id'] = $user->getId();
        $_SESSION['user']['email'] = $user->getEmail();
    }

    public static function logout(): void
    {
        unset($_SESSION['user']['id']);
    }


    public static function user(): User|Admin|null
    {
        if (isset($_SESSION['user']['id'])) {
            $id = $_SESSION['user']['id'];
            $email = $_SESSION['user']['email'];

            if (Admin::findById($id) !== null && Admin::findByEmail($email) !== null) {
                return Admin::findById($id);
            }

            return User::findById($id);
        }

        return null;
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']['id']) && self::user() !== null;
    }
}
