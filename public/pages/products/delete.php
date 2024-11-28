<?php

require '/var/www/app/models/Product.php';

$method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

if ($method !== "DELETE") {
  header('Location: /pages/products');
  exit;
}

$product = Product::findById($_POST['product']['id']);

$product->destroy();

header('Location: /pages/products');
