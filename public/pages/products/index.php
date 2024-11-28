<?php

define("DB_PATH", '/var/www/database/products.txt');

$products = file(DB_PATH, FILE_IGNORE_NEW_LINES);

$title = 'Produtos Cadastrados';
$view = '/var/www/app/views/products/index.phtml';

require '/var/www/app/views/layouts/application.phtml';
