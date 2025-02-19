<?php

use Core\Router\Route;
use App\Controllers\BudgetsController;
use App\Controllers\ProductsController;
use App\Controllers\DashboardController;
use App\Controllers\AuthenticationsController;
use App\Controllers\ProfileController;


// PAREI FAZENDO AS ROTAS NOVAS DO ORÇAMENTO EXCLUIR E EDITAR.. PRECISO FAZER O AJAX PARA ADICIONAR PRODUTO ( FETCH NA ROTA DO BACK PARA SALVAR NO BACNO EM ITEMS )
// LOGO APOS ADICIOANR NOVA COLUNA EM BUDGET DE DELETED PRA CONSEGUIR FAZER UM SOFT DELETE.


Route::get('/login', [AuthenticationsController::class, 'new'])->name('login');
Route::post('/login', [AuthenticationsController::class, 'authenticate'])->name('authenticate');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('root');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::post('/update-avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update_avatar');

    Route::get('/budgets/page/{page}', [BudgetsController::class, 'index'])->name('budgets.paginate');

    Route::get('/logout', [AuthenticationsController::class, 'destroy'])->name('logout');
});

Route::middleware('admin')->group(function () {
    // create products
    Route::get('/admin/products/new', [ProductsController::class, 'new'])->name('admin.products.new');
    Route::post('/admin/products', [ProductsController::class, 'create'])->name('admin.products.create');
    Route::get('/admin/products/page/{page}', [ProductsController::class, 'index'])->name('admin.products.paginate');

    // retrive all products
    Route::get('/admin/products', [ProductsController::class, 'index'])->name('admin.products.index');

    // retrive product
    Route::get('/admin/products/{id}', [ProductsController::class, 'show'])->name('admin.products.show');

    // update product
    Route::get('/admin/products/{id}/edit', [ProductsController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [ProductsController::class, 'update'])->name('admin.products.update');

    // delelte product
    Route::delete('/admin/products/{id}', [ProductsController::class, 'destroy'])->name('admin.products.destroy');

    // craete budget
    Route::get('/admin/budgets/new', [BudgetsController::class, 'new'])->name('admin.budgets.new');
    Route::post('/admin/budgets', [BudgetsController::class, 'create'])->name('admin.budgets.create');
    Route::post('/admin/budgets/add_item', [BudgetsController::class, 'test'])->name('admin.budgets.test');

    // retrive all budgets
    Route::get('/admin/budgets', [BudgetsController::class, 'index'])->name('admin.budgets.index');
    // Route::get('/admin/budgets/page/{page}', [BudgetsController::class, 'index'])->name('admin.budgets.paginate');

    // retrive budget
    Route::get('/admin/budgets/{id}', [BudgetsController::class, 'show'])->name('admin.budgets.show');

    // update budget
    Route::get('/admin/budgets/{id}/edit', [BudgetsController::class, 'show'])->name('admin.budgets.edit');
});

Route::middleware(middleware: 'customer')->group(function () {
    Route::get('/budgets', [BudgetsController::class, 'index'])->name('customer.budgets.index');
    // Route::get('/budgets/page/{page}', [BudgetsController::class, 'index'])->name('customer.budgets.paginate');
    Route::get('/budgets/{id}', [BudgetsController::class, 'show'])->name('customer.budgets.show');
});
