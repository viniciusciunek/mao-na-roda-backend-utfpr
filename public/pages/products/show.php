<?php

$id = intval($_GET['id']);

define('DB_PATH', '/var/www/database/products.txt');
$products = file(DB_PATH, FILE_IGNORE_NEW_LINES);

$product = $products[$id];
$product_name = explode("|", $product)[0];
$product_description = explode("|", $product)[1];
$product_brand = explode("|", $product)[2];
$product_price = explode("|", $product)[3];

$title = "Visualização do Produto #{$id}";
$view = '/var/www/app/views/products/show.phtml';

require '/var/www/app/views/layouts/application.phtml';
