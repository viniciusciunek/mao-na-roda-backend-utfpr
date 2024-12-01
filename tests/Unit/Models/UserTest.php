<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = new User(
            name: 'User 1',
            email: 'fulano@example.com',
            password: '123456',
            password_confirmation: '123456',
            phone: '(11) 1 1111-1111',
            cpf: '111.111.111-11',
            cnpj: '11.111.111/1111-11'
        );
        $this->user->save();
    }

    public function test_should_create_new_user(): void
    {
        $this->assertCount(1, User::all());
    }

    public function test_all_should_return_all_users(): void
    {
        $user = new User(
            name: 'User 2',
            email: 'fulano1@example.com',
            password: '123456',
            password_confirmation: '123456',
            phone: '(22) 2 2222-2222',
            cpf: '222.222.222-22',
            cnpj: '22.222.222/2222-22'
        );
        $user->save();

        $users[] = $this->user->getId();
        $users[] = $user->getId();

        $all = array_map(fn($user) => $user->getId(), User::all());

        $this->assertCount(2, $all);
        $this->assertEquals($users, $all);
    }

    public function test_destroy_should_remove_the_user(): void
    {
        $user = new User(
            name: 'User 2',
            email: 'fulano1@example.com',
            password: '123456',
            password_confirmation: '123456',
            phone: '(22) 2 2222-2222',
            cpf: '222.222.222-22',
            cnpj: '22.222.222/2222-22'
        );
        $user->save();

        $this->user->destroy();

        $this->assertCount(1, User::all());
    }

    public function test_set_id(): void
    {
        $this->user->setId(10);
        $this->assertEquals(10, $this->user->getId());
    }

    public function test_set_name(): void
    {
        $this->user->setName('User name');
        $this->assertEquals('User name', $this->user->getName());
    }

    public function test_set_email(): void
    {
        $this->user->setEmail('outro@example.com');
        $this->assertEquals('outro@example.com', $this->user->getEmail());
    }

    public function test_errors_should_return_errors(): void
    {
        $user = new User();

        $this->assertFalse($user->isValid());
        $this->assertFalse($user->save());
        $this->assertFalse($user->hasErrors());

        $this->assertEquals('não pode ser vazio!', $user->errors('name'));
        $this->assertEquals('não pode ser vazio!', $user->errors('email'));
        $this->assertEquals('não pode ser vazio!', $user->errors('password'));
        $this->assertEquals('não pode ser vazio!', $user->errors('phone'));
        $this->assertEquals('não pode ser vazio!', $user->errors('cpf'));
        $this->assertEquals('não pode ser vazio!', $user->errors('password'));
    }

    public function test_errors_should_return_password_confirmation_error(): void
    {
        $user = new User(
            name: 'User 2',
            email: 'fulano1@example.com',
            password: '123456',
            password_confirmation: '1234567',
            phone: '(22) 2 2222-2222',
            cpf: '222.222.222-22',
            cnpj: '22.222.222/2222-22'
        );

        $this->assertFalse($user->isValid());
        $this->assertFalse($user->save());

        $this->assertEquals('as senhas devem ser idênticas!', $user->errors('password'));
    }

    public function test_find_by_id_should_return_the_user(): void
    {
        for ($i = 0; $i < 2; $i++) {
            (new User(
                name: 'User ' . $i,
                email: 'fulano' . $i . '@example.com',
                password: '123456',
                password_confirmation: '123456',
                phone: "($i$i) $i $i$i$i$i-$i$i$i$i",
                cpf: "$i$i$i.$i$i$i.$i$i$i-$i$i",
                cnpj: "$i$i.$i$i$i.$i$i$i/$i$i$i$i-$i$i"
            ))->save();
        }

        $this->assertEquals($this->user->getId(), User::findById($this->user->getId())->getId());
    }

    public function test_find_by_id_should_return_null(): void
    {
        $this->assertNull(User::findById(2));
    }

    public function test_find_by_email_should_return_the_user(): void
    {
        for ($i = 0; $i < 2; $i++) {
            (new User(
                name: 'User ' . $i,
                email: 'fulano' . $i . '@example.com',
                password: '123456',
                password_confirmation: '123456',
                phone: "($i$i) $i $i$i$i$i-$i$i$i$i",
                cpf: "$i$i$i.$i$i$i.$i$i$i-$i$i",
                cnpj: "$i$i.$i$i$i.$i$i$i/$i$i$i$i-$i$i"
            ))->save();
        }

        $this->assertEquals($this->user->getId(), User::findByEmail($this->user->getEmail())->getId());
    }

    public function test_find_by_email_should_return_null(): void
    {
        $this->assertNull(User::findByEmail('not.exits@example.com'));
    }

    public function test_authenticate_should_return_the_true(): void
    {
        $this->assertTrue($this->user->authenticate('123456'));
        $this->assertFalse($this->user->authenticate('wrong'));
    }
}
