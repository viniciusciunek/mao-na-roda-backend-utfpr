<?php

namespace Config;

class App
{
    public static array $middlewareAliases = [
        'auth' => \App\Middleware\Authenticate::class,
        'admin' => \App\Middleware\AdminMiddleware::class,
        'customer' => \App\Middleware\CustomerMiddleware::class
    ];
}
