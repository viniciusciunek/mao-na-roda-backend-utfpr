<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Core\Http\Request;
use Core\Constants\Constants;

abstract class BaseControllerTestCase extends TestCase
{
    private Request $request;

    public function setUp(): void
    {
        parent::setUp();
        require Constants::rootPath()->join('config/routes.php');

        $_REQUEST['_method'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';

        $this->request = new Request();
    }

    public function tearDown(): void
    {
        unset($_REQUEST['_method']);
        unset($_SERVER['REQUEST_URI']);
    }

    public function get(string $action, string $controller): string
    {
        $controller = new $controller();

        ob_start();

        try {
            $controller->$action($this->request);
            return ob_get_contents();
        } catch (\Exception $e) {
            throw $e;
        } finally {
            ob_end_clean();
        }
    }
}
