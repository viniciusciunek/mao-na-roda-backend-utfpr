<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use Lib\FlashMessage;
use Core\Http\Request;
use App\Models\Product;
use Lib\Authentication\Auth;

class ProductsController
{
    private string $layout = 'application';

    private Customer|Admin|null $currentUser = null;

    public function isAdmin(): bool
    {
        return Auth::user() instanceof Admin;
    }

    public function currentUser(): Customer|Admin|null
    {
        if ($this->currentUser === null && isset($_SESSION['user']['id'])) {
            $this->currentUser = Auth::user();
        }

        return $this->currentUser;
    }

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

        $params = array_map('trim', $params);

        $product = new Product(
            name: $params['name'],
            description: $params['description'],
            brand: $params['brand'],
            price: (float) $params['price']
        );

        if ($product->save()) {
            FlashMessage::success("Produto criado com sucesso!");

            $this->redirectTo(route('products.index'));
        } else {
            FlashMessage::danger("Erro ao criar produto!");

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

        $params['product'] = array_map('trim', $params['product']);

        $product = Product::findById($params['id']);
        $product->setName($params['product']['name']);
        $product->setDescription($params['product']['description']);
        $product->setBrand($params['product']['brand']);
        $product->setPrice((float) $params['product']['price']);

        if ($product->save()) {
            FlashMessage::success("Produto editado com sucesso!");

            $this->redirectTo(route('products.index'));
        } else {
            FlashMessage::danger("Erro ao editar produto!");

            $title = "Editar Produto #{$product->getId()}";
            $this->render('edit', compact('product', 'title'));
        }
    }

    public function destroy(Request $request): void
    {
        $params = $request->getParams();

        $product = Product::findById($params['id']);
        $product->destroy();

        FlashMessage::success("Produto removido com sucesso!");

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
