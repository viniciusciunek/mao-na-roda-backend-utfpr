<?php

namespace Database\Populate;

use App\Models\User;

class UsersPopulate
{
    public static function populate()
    {
        $user = new User(
            name: 'User 1',
            email: 'fulano@example.com',
            password: '123456',
            password_confirmation: '123456',
            phone: '(11) 1 1111-1111',
            cpf: '111.111.111-11',
            cnpj: '11.111.111/1111-11'
        );

        $user->save();

        $numberOfUsers = 10;

        for ($i = 1; $i < $numberOfUsers; $i++) {
            $user = new User(
                name: 'User ' . $i,
                email: 'fulano' . $i . '@example.com',
                password: '123456',
                password_confirmation: '123456',
                phone: "($i$i) $i $i$i$i$i-$i$i$i$i",
                cpf: "$i$i$i.$i$i$i.$i$i$i-$i$i",
                cnpj: "$i$i.$i$i$i.$i$i$i/$i$i$i$i-$i$i"
            );
            $user->save();
        }


        echo "Users populated with $numberOfUsers registers\n";
    }
}
