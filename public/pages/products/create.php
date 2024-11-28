<?php

require '/var/www/app/models/Product.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
  header('Location: /pages/products');
  exit;
}

$data = $_POST['product'];

$product = new Product($data['name'], $data['description'], $data['brand'], (float) $data['price']);

if ($product->save()) {
  header('Location: /pages/products');
} else {
  $title = 'Novo Produto';
  $view = '/var/www/app/views/products/new.phtml';

  require '/var/www/app/views/layouts/application.phtml';
}
