<?php

$method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

if ($method !== 'PUT') {
  header('Location: /pages/products');
  exit;
}

$product = $_POST['product'];

$id = $product['id'];
$name = trim($product['name']);
$description = trim($product['description']);
$brand = trim($product['brand']);
$price = trim($product['price']);

$errors = [];

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

  $products = file(DB_PATH, FILE_IGNORE_NEW_LINES);
  $products[$id] = "$name | $description | $brand | $price";

  $data = implode(PHP_EOL, $products);
  file_put_contents(DB_PATH, $data . PHP_EOL);

  header('Location: /pages/products');
} else {
  $title = "Editar Produto #{$id}";
  $view = '/var/www/app/views/problems/edit.phtml';

  require '/var/www/app/views/layouts/application.phtml';
}
