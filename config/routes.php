<?php

use Core\Router\Route;
use App\Controllers\BudgetsController;
use App\Controllers\ProductsController;
use App\Controllers\DashboardController;
use App\Controllers\AuthenticationsController;

Route::get('/login', [AuthenticationsController::class, 'new'])->name('customers.login');
Route::post('/login', [AuthenticationsController::class, 'authenticate'])->name('customers.authenticate');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('root');

    // ------------------------------- Products ------------------------------------
    // Create
    Route::get('/products/new', [ProductsController::class, 'new'])->name('products.new');
    Route::post('/products', [ProductsController::class, 'create'])->name('products.create');

    // Retrieve
    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/products/page/{page}', [ProductsController::class, 'index'])->name('products.paginate');
    Route::get('/products/{id}', [ProductsController::class, 'show'])->name('products.show');

    // Update
    Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductsController::class, 'update'])->name('products.update');

    // Delete
    Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');

    // Logout
    Route::get('/logout', [AuthenticationsController::class, 'destroy'])->name('customers.logout');
    // ------------------------------- End Products --------------------------------

    // ------------------------------- Budgets ------------------------------------
    Route::get('/budgets', [BudgetsController::class, 'index'])->name('budgets.index');
    Route::get('/budgets/page/{page}', [BudgetsController::class, 'index'])->name('budgets.paginate');

    // Create
    Route::get('/budgets/new', [BudgetsController::class, 'new'])->name('budgets.new');
    Route::post('/budgets', [BudgetsController::class, 'create'])->name('budgets.create');
    Route::post('/budgets/add_item', [BudgetsController::class, 'test'])->name('budgets.test');

    // Show
    Route::get('/budgets/{id}', [BudgetsController::class, 'show'])->name('budgets.show');
});
