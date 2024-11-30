<?php

namespace App\Controllers;

use App\Models\Product;
use Core\Http\Request;

class ProductsController
{
    private string $layout = 'application';

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

    /**
     * @param array<string, mixed> $data
     */
    private function render(string $view, array $data = []): void
    {
        extract($data);

        $view = '/var/www/app/views/products/' . $view . '.phtml';

        require '/var/www/app/views/layouts/' . $this->layout . '.phtml';
    }

    /**
     * @param array<string, mixed> $data
     */
    private function renderJson(string $view, array $data = []): void
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

    public function show(): void
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

    public function create(Request $request): void
    {
        $params = $request->getParams();

        $product = new Product($params['product']['name'], $params['product']['description'], $params['product']['brand'], (float) $params['product']['price']);

        if ($product->save()) {
            $this->redirectTo(route('products.index'));
        } else {
            $title = 'Novo Produto';
            $this->render('new', compact('product', 'title'));
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

    private function redirectTo(string $location): void
    {
        header('Location: ' . $location);
        exit;
    }
}
