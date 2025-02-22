<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use Core\Http\Controllers\Controller;
use Lib\FlashMessage;
use Core\Http\Request;
use App\Models\Product;
use Lib\Authentication\Auth;
use Lib\Paginator;

class ProductsController extends Controller
{
    public function index(Request $request): void
    {
        $paginator = new Paginator(
            Product::class,
            $request->getParam('page', 1),
            10,
            Product::table(),
            Product::columns(),
            ['active' => 1]
        );

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

        $title = "Visualização do Produto #{$product->id}";

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

        $product = new Product([
            'name' =>  $params['name'],
            'description' => $params['description'],
            'brand' => $params['brand'],
            'price' => (float) $params['price'],
            'active' => 1
        ]);

        if ($product->save()) {
            FlashMessage::success("Produto criado com sucesso!");

            $this->redirectTo(route('admin.products.index'));
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

        $title = "Editar Produto #{$product->id}";

        $this->render('products/edit', compact('product', 'title'));
    }

    public function update(Request $request): void
    {
        $params = $request->getParams();

        $params['product'] = array_map('trim', $params['product']);

        $product = Product::findById($params['id']);
        $product->name  = $params['product']['name'];
        $product->description = $params['product']['description'];
        $product->brand = $params['product']['brand'];
        $product->price = (float) $params['product']['price'];

        if ($product->save()) {
            FlashMessage::success("Produto editado com sucesso!");

            $this->redirectTo(route('admin.products.index'));
        } else {
            FlashMessage::danger("Erro ao editar produto!");

            $title = "Editar Produto #{$product->id}";
            $this->render('products/edit', compact('product', 'title'));
        }
    }

    public function destroy(Request $request): void
    {
        $params = $request->getParams();

        $product = Product::findById($params['id']);
        // $product->destroy();

        $product->update([
            'active' => 0
        ]);

        FlashMessage::success("Produto removido com sucesso!");

        $this->redirectTo(route('admin.products.index'));
    }
}
