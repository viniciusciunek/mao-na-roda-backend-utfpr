<?php

$id = intval($_GET['id']);

define("DB_PATH", '/var/www/database/products.txt');

$products = file(DB_PATH, FILE_IGNORE_NEW_LINES);

$product['id'] = $id;
$product['name'] = trim(explode("|", $products[$id])[0]);
$product['description'] = trim(explode("|", $products[$id])[1]);
$product['brand'] = trim(explode("|", $products[$id])[2]);
$product['price'] = trim(explode("|", $products[$id])[3]);

$title = "Editar Produto #{$id}";
$view = "/var/www/app/views/products/edit.phtml";

require '/var/www/app/views/layouts/application.phtml';
