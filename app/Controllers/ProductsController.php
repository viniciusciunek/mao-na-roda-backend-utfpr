<?php

namespace App\Controllers;

use App\Models\Product;

class ProductsController
{
    private $layout = 'application';

    public function index(): void
    {
        $products = Product::all();

        $title = 'Produtos Cadastrados';

        if ($this->isJsonRequest()) {
            $this->renderJson('index', compact('products', 'title'));
        } else {
            $this->render('index', compact('products', 'title'));
        }
    }

    private function render($view, $data = []): void
    {
        extract($data);

        $view = '/var/www/app/views/products/' . $view . '.phtml';

        require '/var/www/app/views/layouts/' . $this->layout . '.phtml';
    }

    private function renderJson($view, $data = []): void
    {
        extract($data);

        $view = '/var/www/app/views/products/' . $view . '.json.php';
        $json = [];

        header('Content-Type: application/json; charset=utf-8');
        require $view;
        var_dump($json);
        echo json_encode($json);
        return;
    }

    private function isJsonRequest(): bool
    {
        return (isset($_SERVER['HTTP_ACCEPT']) && $_SERVER['HTTP_ACCEPT'] === 'application/json');
    }

    public function show()
    {
        $id = intval($_GET['id']);

        $product = Product::findById($id);

        $title = "Visualização do Produto #{$id}";

        $this->render('show', compact('product', 'title'));
    }

    public function new(): void
    {
        $product = new Product();

        $title = 'Cadastrar Produto';

        $this->render('new', compact('product', 'title'));
    }

    public function create(): void
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

    public function edit(): void
    {
        $id = intval($_GET['id']);

        $product = Product::findById($id);

        $title = "Editar Produto #{$product->getId()}";

        $this->render('edit', compact('product', 'title'));
    }

    public function update(): void
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

    public function destroy(): void
    {

        $method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

        if ($method !== "DELETE") {
            $this->redirectTo('/pages/products');
        }

        $product = Product::findById($_POST['product']['id']);

        $product->destroy();

        header('Location: /pages/products');
    }

    private function redirectTo($location)
    {
        header('Location: ' . $location);
        exit;
    }
}
