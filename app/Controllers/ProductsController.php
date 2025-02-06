<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use Core\Http\Controllers\Controller;
use Lib\FlashMessage;
use Core\Http\Request;
use App\Models\Product;
use Lib\Authentication\Auth;

class ProductsController extends Controller
{

    public function index(Request $request): void
    {
        $paginator = Product::paginate(page: $request->getParam('page', 1));

        $products = $paginator->registers();

        $title = 'Produtos Registrados';

        if ($request->acceptJson()) {
            $this->renderJson('products/index', compact('paginator', 'products', 'title'));
        } else {
            $this->render('products/index', compact('paginator', 'products', 'title'));
        }
    }

    public function show(Request $request): void
    {
        $params = $request->getParams();

        $product = Product::findById($params['id']);

        $title = "Visualização do Produto #{$product->getId()}";

        $this->render('products/show', compact('product', 'title'));
    }

    public function new(): void
    {
        $product = new Product();

        $title = 'Novo Produto';

        $this->render('products/new', compact('product', 'title'));
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
            $this->render('products/new', compact('product', 'title'));
        }
    }

    public function edit(Request $request): void
    {
        $params = $request->getParams();

        $product = Product::findById($params['id']);

        $title = "Editar Produto #{$product->getId()}";

        $this->render('products/edit', compact('product', 'title'));
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
            $this->render('products/edit', compact('product', 'title'));
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
}
