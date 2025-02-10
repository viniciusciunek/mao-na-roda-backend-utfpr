<?php

namespace Database\Populate;

use App\Models\Admin;

class AdminsPopulate
{
    public static function populate(): void
    {
        $admin = new Admin(
            [
                'name' => 'Admin 1',
                'email' => 'admin@example.com',
                'password' => '123456',
                'password_confirmation' => '123456',
            ]
        );

        $admin->save();

        echo 'Admin populated with 1 register' . PHP_EOL;
    }
}
