<?php

use Core\Router\Route;
use App\Controllers\BudgetsController;
use App\Controllers\ProductsController;
use App\Controllers\DashboardController;
use App\Controllers\AuthenticationsController;
use App\Controllers\BudgetItemsController;
use App\Controllers\ProfileController;


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
    Route::get('/admin/products/page/{page}', [ProductsController::class, 'index'])->name('products.paginate');

    // retrive all products
    Route::get('/admin/products', [ProductsController::class, 'index'])->name('admin.products.index');

    // retrive product
    Route::get('/admin/products/{id}', [ProductsController::class, 'show'])->name('admin.products.show');

    // update product
    Route::get('/admin/products/{id}/edit', [ProductsController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [ProductsController::class, 'update'])->name('admin.products.update');

    // delelte product
    Route::delete('/admin/products/{id}', [ProductsController::class, 'destroy'])->name('admin.products.destroy');

    // new budget
    Route::get('/admin/budgets/new', [BudgetsController::class, 'new'])->name('admin.budgets.new');

    // retrive all budgets
    Route::get('/admin/budgets', [BudgetsController::class, 'index'])->name('admin.budgets.index');

    // show budget
    Route::get('/admin/budgets/{id}', [BudgetsController::class, 'show'])->name('admin.budgets.show');

    // edit budget
    Route::get('/admin/budgets/{id}/edit', [BudgetsController::class, 'edit'])->name('admin.budgets.edit');


    // -------------------- rotas ajax --------------------
    Route::post('/admin/budgets', [BudgetsController::class, 'create'])->name('admin.budgets.create'); # criando o orçamento primeiro

    Route::post('/admin/budgets/add_item', [BudgetItemsController::class, 'create'])->name('admin.budget_items.create'); # adicionando produtos

    Route::delete('/admin/budgets/remove_item', [BudgetItemsController::class, 'destroy'])->name('admin.budget_items.destroy'); # removendo produtos
});

Route::middleware(middleware: 'customer')->group(function () {
    Route::get('/budgets', [BudgetsController::class, 'index'])->name('customer.budgets.index');
    Route::get('/budgets/{id}', [BudgetsController::class, 'show'])->name('customer.budgets.show');
});
