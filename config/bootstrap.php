<?php

require __DIR__ . '/../vendor/autoload.php';

use Core\Errors\ErrorsHandler;
use Core\Environments\EnvLoader;
use Core\Router\Router;

ErrorsHandler::init();
EnvLoader::init();
Router::init();
