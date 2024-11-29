<?php

require '/var/www/app/models/Product.php';

class ProductsController
{
  private $layout = 'application';

  public function index()
  {
    $products = Product::all();

    $title = 'Produtos Cadastrados';

    $this->render('index', compact('products', 'title'));
  }

  private function render($view, $data = [])
  {
    extract($data);

    $view = '/var/www/app/views/products/' . $view . '.phtml';

    require '/var/www/app/views/layouts/' . $this->layout . '.phtml';
  }

  public function new()
  {
    $product = new Product();

    $title = 'Cadastrar Produto';

    $this->render('new', compact('product', 'title'));
  }

  public function create()
  {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method !== 'POST') {
      $this->redirectTo('/pages/products');
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
  }

  public function edit()
  {
    $id = intval($_GET['id']);

    $product = Product::findById($id);

    $title = "Editar Produto #{$product->getId()}";

    $this->render('edit', compact('product', 'title'));
  }

  public function update()
  {

    $method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

    if ($method !== 'PUT') {
      $this->redirectTo('/pages/products');
    }

    $product = Product::findById($_POST['product']['id']);
    $product->setName($_POST['product']['name']);
    $product->setDescription($_POST['product']['description']);
    $product->setBrand($_POST['product']['brand']);
    $product->setPrice($_POST['product']['price']);

    if ($product->save()) {
      $this->redirectTo('/pages/products');
    } else {
      $title = "Editar Produto #{$product->getId()}";

      $this->render('edit', compact('product', 'title'));
    }
  }

  private function redirectTo($location)
  {
    header('Location: ' . $location);
    exit;
  }
}
