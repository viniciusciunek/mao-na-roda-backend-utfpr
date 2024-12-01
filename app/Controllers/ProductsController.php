<?php

namespace App\Controllers;

use App\Models\Product;
use Core\Http\Request;

class ProductsController
{
    private string $layout = 'application';

    public function index(Request $request): void
    {
        $paginator = Product::paginate(page: $request->getParam('page', 1));

        $products = $paginator->registers();

        $title = 'Produtos Registrados';

        if ($request->acceptJson()) {
            $this->renderJson('index', compact('paginator', 'products', 'title'));
        } else {
            $this->render('index', compact('paginator', 'products', 'title'));
        }
    }

    public function show(Request $request): void
    {
        $params = $request->getParams();

        $product = Product::findById($params['id']);

        $title = "Visualização do Produto #{$product->getId()}";
        $this->render('show', compact('product', 'title'));
    }

    public function new(): void
    {
        $product = new Product();

        $title = 'Novo Produto';
        $this->render('new', compact('product', 'title'));
    }

    public function create(Request $request): void
    {
        $params = $request->getParams()['product'];

        $product = new Product(
            name: $params['name'],
            description: $params['description'],
            brand: $params['brand'],
            price: (float) $params['price']
        );

        if ($product->save()) {
            $this->redirectTo(route('products.index'));
        } else {
            $title = 'Novo Produto';
            $this->render('new', compact('product', 'title'));
        }
    }

    public function edit(Request $request): void
    {
        $params = $request->getParams();
        $product = Product::findById($params['id']);

        $title = "Editar Produto #{$product->getId()}";
        $this->render('edit', compact('product', 'title'));
    }

    public function update(Request $request): void
    {
        $params = $request->getParams();

        $product = Product::findById($params['id']);
        $product->setName($_POST['product']['name']);
        $product->setDescription($_POST['product']['description']);
        $product->setBrand($_POST['product']['brand']);
        $product->setPrice($_POST['product']['price']);

        if ($product->save()) {
            $this->redirectTo(route('products.index'));
        } else {
            $title = "Editar Produto #{$product->getId()}";
            $this->render('edit', compact('product', 'title'));
        }
    }

    public function destroy(Request $request): void
    {
        $params = $request->getParams();

        $product = Product::findById($params['id']);
        $product->destroy();

        $this->redirectTo(route('products.index'));
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

        header('Content-Type: application/json; chartset=utf-8');
        require $view;
        echo json_encode($json);
        return;
    }

    private function redirectTo(string $location): void
    {
        header('Location: ' . $location);
        exit;
    }
}
