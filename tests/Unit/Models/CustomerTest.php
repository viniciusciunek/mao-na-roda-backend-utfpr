<?php

namespace Tests\Unit\Models;

use App\Models\Customer;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    private Customer $customer;

    public function setUp(): void
    {
        parent::setUp();
        $this->customer = new Customer(
            [
                'name' => 'Customer 1',
                'email' => 'fulano@example.com',
                'password' => '123456',
                'password_confirmation' => '123456',
                'phone' => '(11) 1 1111-1111',
                'cpf' => '111.111.111-11',
                'cnpj' => '11.111.111/1111-11'
            ]
        );

        $this->customer->save();
    }

    public function test_should_create_new_user(): void
    {
        $this->assertCount(1, Customer::all());
    }

    public function test_all_should_return_all_users(): void
    {
        $customer = new Customer(
            [
                'name' => 'Customer 2',
                'email' => 'fulano1@example.com',
                'password' => '123456',
                'password_confirmation' => '123456',
                'phone' => '(22) 2 2222-2222',
                'cpf' => '222.222.222-22',
                'cnpj' => '22.222.222/2222-22'
            ]
        );

        $customer->save();

        $customers[] = $this->customer->id;
        $customers[] = $customer->id;

        $all = array_map(fn($customer) => $customer->id, Customer::all());

        $this->assertCount(2, $all);
        $this->assertEquals($customers, $all);
    }

    public function test_destroy_should_remove_the_user(): void
    {
        $customer = new Customer(
            [
                'name' => 'Customer 2',
                'email' => 'fulano1@example.com',
                'password' => '123456',
                'password_confirmation' => '123456',
                'phone' => '(22) 2 2222-2222',
                'cpf' => '222.222.222-22',
                'cnpj' => '22.222.222/2222-22'
            ]
        );
        $customer->save();

        $this->customer->destroy();

        $this->assertCount(1, Customer::all());
    }

    public function test_set_id(): void
    {
        $this->customer->id = 10;
        $this->assertEquals(10, $this->customer->id);
    }

    public function test_set_name(): void
    {
        $this->customer->name = 'Customer name';
        $this->assertEquals('Customer name', $this->customer->name);
    }

    public function test_set_email(): void
    {
        $this->customer->email = 'outro@example.com';
        $this->assertEquals('outro@example.com', $this->customer->email);
    }

    public function test_errors_should_return_errors(): void
    {
        $customer = new Customer();

        $this->assertFalse($customer->isValid());
        $this->assertFalse($customer->save());
        $this->assertFalse($customer->hasErrors());

        $this->assertEquals('não pode ser vazio!', $customer->errors('name'));
        $this->assertEquals('não pode ser vazio!', $customer->errors('email'));
        $this->assertEquals('não pode ser vazio!', $customer->errors('phone'));
    }

    public function test_errors_should_return_password_confirmation_error(): void
    {
        $customer = new Customer(
            [
                'name' => 'Customer 2',
                'email' => 'fulano1@example.com',
                'password' => '123456',
                'password_confirmation' => '1234567',
                'phone' => '(22) 2 2222-2222',
                'cpf' => '222.222.222-22',
                'cnpj' => '22.222.222/2222-22'
            ]
        );

        $this->assertFalse($customer->isValid());
        $this->assertFalse($customer->save());

        $this->assertEquals('as senhas devem ser idênticas!', $customer->errors('password'));
    }

    public function test_find_by_id_should_return_the_user(): void
    {
        for ($i = 0; $i < 2; $i++) {
            (new Customer(
                [
                    'name' => 'Customer ' . $i,
                    'email' => 'fulano' . $i . '@example.com',
                    'password' => '123456',
                    'password_confirmation' => '123456',
                    'phone' => "($i$i) $i $i$i$i$i-$i$i$i$i",
                    'cpf' => "$i$i$i.$i$i$i.$i$i$i-$i$i",
                    'cnpj' => "$i$i.$i$i$i.$i$i$i/$i$i$i$i-$i$i"
                ]
            ))->save();
        }

        $this->assertEquals($this->customer->id, Customer::findById($this->customer->id)->id);
    }

    public function test_find_by_id_should_return_null(): void
    {
        $this->assertNull(Customer::findById(2));
    }

    public function test_find_by_email_should_return_the_user(): void
    {
        for ($i = 0; $i < 2; $i++) {
            (new Customer(
                [
                    'name' => 'Customer ' . $i,
                    'email' => 'fulano' . $i . '@example.com',
                    'password' => '123456',
                    'password_confirmation' => '123456',
                    'phone' => "($i$i) $i $i$i$i$i-$i$i$i$i",
                    'cpf' => "$i$i$i.$i$i$i.$i$i$i-$i$i",
                    'cnpj' => "$i$i.$i$i$i.$i$i$i/$i$i$i$i-$i$i"
                ]
            ))->save();
        }

        $this->assertEquals($this->customer->id, Customer::findByEmail($this->customer->email)->id);
    }

    public function test_find_by_email_should_return_null(): void
    {
        $this->assertNull(Customer::findByEmail('not.exits@example.com'));
    }

    public function test_authenticate_should_return_the_true(): void
    {
        $this->assertTrue($this->customer->authenticate('123456'));
        $this->assertFalse($this->customer->authenticate('wrong'));
    }

    public function test_authenticate_should_return_false(): void
    {
        $this->assertFalse($this->customer->authenticate(''));
    }

    public function test_update_should_not_change_the_password(): void
    {
        $this->customer->password = '654321';
        $this->customer->save();

        $this->assertTrue($this->customer->authenticate('123456'));
        $this->assertFalse($this->customer->authenticate('654321'));
    }
}
