<?php

use Core\Router\Route;
use App\Controllers\BudgetsController;
use App\Controllers\ProductsController;
use App\Controllers\DashboardController;
use App\Controllers\AuthenticationsController;

Route::get('/login', [AuthenticationsController::class, 'new'])->setName('customers.login');
Route::post('/login', [AuthenticationsController::class, 'authenticate'])->setName('customers.authenticate');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->setName('root');

    // ------------------------------- Products ------------------------------------
    // Create
    Route::get('/products/new', [ProductsController::class, 'new'])->setName('products.new');
    Route::post('/products', [ProductsController::class, 'create'])->setName('products.create');

    // Retrieve
    Route::get('/products', [ProductsController::class, 'index'])->setName('products.index');
    Route::get('/products/page/{page}', [ProductsController::class, 'index'])->setName('products.paginate');
    Route::get('/products/{id}', [ProductsController::class, 'show'])->setName('products.show');

    // Update
    Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])->setName('products.edit');
    Route::put('/products/{id}', [ProductsController::class, 'update'])->setName('products.update');

    // Delete
    Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->setName('products.destroy');

    // Logout
    Route::get('/logout', [AuthenticationsController::class, 'destroy'])->setName('customers.logout');
    // ------------------------------- End Products --------------------------------

    // ------------------------------- Budgets ------------------------------------
    Route::get('/budgets', [BudgetsController::class, 'index'])->setName('budgets.index');
    Route::get('/budgets/page/{page}', [BudgetsController::class, 'index'])->setName('budgets.paginate');

    // Create
    Route::get('/budgets/new', [BudgetsController::class, 'new'])->setName('budgets.new');
    Route::post('/budgets', [BudgetsController::class, 'create'])->setName('budgets.create');
    Route::post('/budgets/add_item', [BudgetsController::class, 'test'])->setName('budgets.test');

    // Show
    Route::get('/budgets/{id}', [BudgetsController::class, 'show'])->setName('budgets.show');
});
