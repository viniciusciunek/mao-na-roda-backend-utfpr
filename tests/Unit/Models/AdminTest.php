<?php

namespace Tests\Unit\Models;

use App\Models\Admin;
use Tests\TestCase;

class AdminTest extends TestCase
{
    private Admin $admin;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = new Admin(
            [
                'name' => 'Admin 1',
                'email' => 'admin@example.com',
                'password' => '123456',
                'password_confirmation' => '123456'
            ]
        );

        $this->admin->save();
    }

    public function test_should_create_new_admin(): void
    {
        $this->assertCount(1, Admin::all());
    }

    public function test_all_should_return_all_admins(): void
    {
        $admin = new Admin(
            [
                'name' => 'Admin 2',
                'email' => 'admin1@example.com',
                'password' => '123456',
                'password_confirmation' => '123456'
            ]
        );

        $admin->save();

        $admins[] = $this->admin->id;
        $admins[] = $admin->id;

        $all = array_map(fn($admin) => $admin->id, Admin::all());

        $this->assertCount(2, $all);
        $this->assertEquals($admins, $all);
    }

    public function test_destroy_should_remove_the_admin(): void
    {
        $admin = new Admin(
            [
                'name' => 'Customer 2',
                'email' => 'fulano1@example.com',
                'password' => '123456',
                'password_confirmation' => '123456'
            ]
        );

        $admin->save();

        $this->admin->destroy();

        $this->assertCount(1, Admin::all());
    }

    public function test_set_id(): void
    {
        $this->admin->id = 10;

        $this->assertEquals(10, $this->admin->id);
    }

    public function test_set_name(): void
    {
        $this->admin->name = 'Admin name';

        $this->assertEquals('Admin name', $this->admin->name);
    }

    public function test_set_email(): void
    {
        $this->admin->email = 'outro@example.com';

        $this->assertEquals('outro@example.com', $this->admin->email);
    }

    public function test_errors_should_return_errors(): void
    {
        $admin = new Admin();

        $this->assertFalse($admin->isValid());
        $this->assertFalse($admin->save());
        $this->assertFalse($admin->hasErrors());
    }

    public function test_errors_should_return_password_confirmation_error(): void
    {
        $admin = new Admin(
            [
                'name' => 'Customer 2',
                'email' => 'fulano1@example.com',
                'password' => '123456',
                'password_confirmation' => '1234567'
            ]
        );

        $this->assertFalse($admin->isValid());
        $this->assertFalse($admin->save());

        $this->assertEquals('as senhas devem ser idênticas!', $admin->errors('password'));
    }

    public function test_find_by_id_should_return_the_admin(): void
    {
        for ($i = 0; $i < 2; $i++) {
            (new Admin(
                [
                    'name' => 'Admin ' . $i,
                    'email' => 'admin' . $i . '@example.com',
                    'password' => '123456',
                    'password_confirmation' => '123456'
                ]
            ))->save();
        }

        $this->assertEquals($this->admin->id, Admin::findById($this->admin->id)->id);
    }

    public function test_find_by_id_should_return_null(): void
    {
        $this->assertNull(Admin::findById(2));
    }

    public function test_find_by_email_should_return_the_admin(): void
    {
        for ($i = 0; $i < 2; $i++) {
            (new Admin(
                [
                    'name' => 'Admin ' . $i,
                    'email' => 'admin' . $i . '@example.com',
                    'password' => '123456',
                    'password_confirmation' => '123456'
                ]
            ))->save();
        }

        $this->assertEquals($this->admin->id, Admin::findByEmail($this->admin->email)->id);
    }

    public function test_find_by_email_should_return_null(): void
    {
        $this->assertNull(Admin::findByEmail('not.exits@example.com'));
    }

    public function test_authenticate_should_return_the_true(): void
    {
        $this->assertTrue($this->admin->authenticate('123456'));
        $this->assertFalse($this->admin->authenticate('wrong'));
    }

    public function test_authenticate_should_return_false(): void
    {
        $this->assertFalse($this->admin->authenticate(''));
    }

    public function test_update_should_not_change_the_password(): void
    {
        $this->admin->password = '654321';
        $this->admin->save();

        $this->assertTrue($this->admin->authenticate('123456'));
        $this->assertFalse($this->admin->authenticate('654321'));
    }
}
