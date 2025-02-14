<?php

namespace Database\Populate;

use App\Models\Customer;

class CustomersPopulate
{
    public static function populate()
    {
        // Sempre cria um Customer fixo para login de teste
        $customer1 = new Customer([
            'name'                  => 'Cliente Teste',
            'email'                 => 'customer@example.com',
            'password'              => '123456',
            'password_confirmation' => '123456',
            'phone'                 => '(11) 9 1111-1111',
            'cpf'                   => '111.111.111-11',
            'cnpj'                  => '11.111.111/1111-11'
        ]);
        $customer1->save();

        $customer2 = new Customer([
            'name'                  => 'Cliente Teste2',
            'email'                 => 'cliente2@example.com',
            'password'              => '123456',
            'password_confirmation' => '123456',
            'phone'                 => '(22) 9 2222-2222',
            'cpf'                   => '222.222.222-22',
            'cnpj'                  => '22.222.222/2222-22'
        ]);
        $customer2->save();

        $fakeCustomers = [
            [
                'name'  => 'João da Silva',
                'email' => 'joao.silva@example.com',
                'phone' => '(11) 9 1234-5678',
                'cpf'   => '123.456.789-10',
                'cnpj'  => '11.222.333/0001-44'
            ],
            [
                'name'  => 'Maria Oliveira',
                'email' => 'maria.oliveira@example.com',
                'phone' => '(11) 9 2222-3333',
                'cpf'   => '111.222.333-44',
                'cnpj'  => '44.555.666/0001-77'
            ],
            [
                'name'  => 'Pedro Santos',
                'email' => 'pedro.santos@example.com',
                'phone' => '(21) 9 8888-9999',
                'cpf'   => '333.444.555-66',
                'cnpj'  => '55.666.777/0001-88'
            ],
            [
                'name'  => 'Ana Pereira',
                'email' => 'ana.pereira@example.com',
                'phone' => '(31) 9 7777-8888',
                'cpf'   => '444.555.666-77',
                'cnpj'  => '66.777.888/0001-99'
            ],
            [
                'name'  => 'Rafael Costa',
                'email' => 'rafael.costa@example.com',
                'phone' => '(41) 9 2222-1234',
                'cpf'   => '555.666.777-88',
                'cnpj'  => '77.888.999/0001-00'
            ],
            [
                'name'  => 'Juliana Rodrigues',
                'email' => 'juliana.rodrigues@example.com',
                'phone' => '(51) 9 3333-4444',
                'cpf'   => '666.777.888-99',
                'cnpj'  => '88.999.000/0001-11'
            ],
            [
                'name'  => 'Marcos Almeida',
                'email' => 'marcos.almeida@example.com',
                'phone' => '(61) 9 1111-2222',
                'cpf'   => '777.888.999-00',
                'cnpj'  => '99.000.111/0001-22'
            ],
            [
                'name'  => 'Carla Souza',
                'email' => 'carla.souza@example.com',
                'phone' => '(71) 9 4444-5555',
                'cpf'   => '888.999.000-11',
                'cnpj'  => '10.111.222/0001-33'
            ],
        ];

        foreach ($fakeCustomers as $data) {
            $customer = new Customer([
                'name'                  => $data['name'],
                'email'                 => $data['email'],
                'phone'                 => $data['phone'],
                'cpf'                   => $data['cpf'],
                'cnpj'                  => $data['cnpj'],
                'password'              => '123456',
                'password_confirmation' => '123456',
            ]);
            $customer->save();
        }

        echo "Customers populated with 10 registers (2 fixos + 8 aleatórios)\n";
    }
}
