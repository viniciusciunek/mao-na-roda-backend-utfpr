<?php

namespace Tests\Unit\Core\Router;

use Core\Router\Route;
use Core\Router\Router;
use Core\Http\Middleware\Middleware;
use Core\Router\RouteWrapperMiddleware;
use Tests\Unit\Core\Router\MockController;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

class RouteWrapperMiddlewareTest extends FrameworkTestCase
{
    public function test_group_should_add_middleware_to_routes(): void
    {
        $middlewareName = 'auth';

        $routeWrapperMiddleware = new RouteWrapperMiddleware($middlewareName);

        $routeSizeBefore = Router::getInstance()->getRouteSize();

        $routeWrapperMiddleware->group(function () {
            Route::get('/home', [MockController::class, 'index'])->name('home');
        });

        $routeSizeAfter = Router::getInstance()->getRouteSize();

        for ($i = $routeSizeBefore; $i < $routeSizeAfter; $i++) {
            $route = Router::getInstance()->getRoute($i);

            $reflection = new \ReflectionObject($route);

            $property = $reflection->getProperty('middlewares');

            $property->setAccessible(true);

            $middlewares = $property->getValue($route);

            $this->assertInstanceOf(Middleware::class, $middlewares[0]);
        }
    }
}
