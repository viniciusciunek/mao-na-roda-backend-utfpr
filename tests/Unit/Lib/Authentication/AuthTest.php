<?php

namespace Tests\Unit\Lib\Authentication;

use App\Models\Admin;
use Lib\Authentication\Auth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private Admin $admin;

    public function setUp(): void
    {
        parent::setUp();
        $_SESSION = [];
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

    public function tearDown(): void
    {
        parent::setUp();
        $_SESSION = [];
    }

    public function test_login(): void
    {
        Auth::login($this->admin);

        $this->assertEquals(1, $_SESSION['admin']['id']);
    }

    public function test_admin(): void
    {
        Auth::login($this->admin);

        $adminFromSession = Auth::user();

        $this->assertEquals($this->admin->id, $adminFromSession->id);
    }

    public function test_check(): void
    {
        Auth::login($this->admin);

        $this->assertTrue(Auth::check());
    }

    public function test_logout(): void
    {
        Auth::login($this->admin);
        Auth::logout();

        $this->assertFalse(Auth::check());
    }
}
