<?php

require '/var/www/app/models/Product.php';

$method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

if ($method !== 'PUT') {
  header('Location: /pages/products');
  exit;
}

$product = Product::findById($_POST['product']['id']);
$product->setName($_POST['product']['name']);
$product->setDescription($_POST['product']['description']);
$product->setBrand($_POST['product']['brand']);
$product->setPrice($_POST['product']['price']);

if ($product->save()) {
  header('Location: /pages/products');
} else {
  $title = "Editar Produto #{$product->getId()}";
  $view = '/var/www/app/views/products/edit.phtml';

  require '/var/www/app/views/layouts/application.phtml';
}
