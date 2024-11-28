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
}
