<?php

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
  header('Location: /pages/products');
  exit;
}

$errors = [];

$product = $_POST['product'];
$name = trim($product['name']);
$description = trim($product['description']);
$brand = trim($product['brand']);
$price = trim($product['price']);

if (empty($name)) {
  $errors['name'] = 'Não pode ser vazio!';
}

if (empty($description)) {
  $errors['description'] = 'Insira uma descrição!';
}

if (empty($brand)) {
  $errors['brand'] = 'Insira a marca do produto!';
}

if (empty($price)) {
  $errors['price'] = 'Insira o preço do produto!';
}

if (empty($errors)) {
  define('DB_PATH', '/var/www/database/products.txt');

  file_put_contents(DB_PATH, "$name | $description | $brand | $price" . PHP_EOL, FILE_APPEND);

  header('Location: /pages/products');
} else {
  $title = 'Novo Produto';
  $view = '/var/www/app/views/products/new.phtml';

  require '/var/www/app/views/layouts/application.phtml';
}
