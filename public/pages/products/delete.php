<?php

$method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

if ($method !== "DELETE") {
  header('Location: /pages/products');
  exit;
}

$product = $_POST['product'];

$id = $product['id'];

define("DB_PATH", '/var/www/database/products.txt');

$products = file(DB_PATH, FILE_IGNORE_NEW_LINES);
unset($products[$id]);

$data = implode(PHP_EOL, $products);
file_put_contents(DB_PATH, $data . PHP_EOL);

header('Location: /pages/products');
