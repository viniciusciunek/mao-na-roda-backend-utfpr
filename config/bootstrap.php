<?php

require __DIR__ . '/../vendor/autoload.php';

use Core\Errors\ErrorsHandler;
use Core\Environments\EnvLoader;

ErrorsHandler::init();
EnvLoader::init();

// require_once ROOT_PATH . '/core/debug/functions.php';
