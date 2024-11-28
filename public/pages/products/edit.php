<?php

require '/var/www/core/errors/handler.php';
require '/var/www/app/models/Product.php';

$id = intval($_GET['id']);
$product = Product::findById($id);

$title = "Editar Produto #{$product->getId()}";
$view = "/var/www/app/views/products/edit.phtml";

require '/var/www/app/views/layouts/application.phtml';
