<?php

require '/var/www/app/models/Product.php';

$product = new Product();

$title = 'Novo Produto';
$view = '/var/www/app/views/products/new.phtml';

require '/var/www/app/views/layouts/application.phtml';
