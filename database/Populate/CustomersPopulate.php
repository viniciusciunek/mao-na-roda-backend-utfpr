<?php

namespace Database\Populate;

use App\Models\Customer;

class CustomersPopulate
{
    public static function populate()
    {
        $customer = new Customer(
            [
                'name' => 'Customer 1',
                'email' => 'customer@example.com',
                'password' => '123456',
                'password_confirmation' => '123456',
                'phone' => '(11) 1 1111-1111',
                'cpf' => '111.111.111-11',
                'cnpj' => '11.111.111/1111-11'
            ]
        );

        $customer->save();

        $numberOfUsers = 10;

        for ($i = 1; $i < $numberOfUsers; $i++) {
            $customer = new Customer(
                [
                    'name' => 'Customer ' . $i,
                    'email' => 'customer' . $i . '@example.com',
                    'password' => '123456',
                    'password_confirmation' => '123456',
                    'phone' => "($i$i) $i $i$i$i$i-$i$i$i$i",
                    'cpf' => "$i$i$i.$i$i$i.$i$i$i-$i$i",
                    'cnpj' => "$i$i.$i$i$i.$i$i$i/$i$i$i$i-$i$i"
                ]
            );
            $customer->save();
        }


        echo "Customers populated with $numberOfUsers registers\n";
    }
}
