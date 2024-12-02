<?php

use App\Controllers\AuthenticationsController;
use App\Controllers\DashboardController;
use App\Controllers\ProductsController;
use Core\Router\Route;

Route::get('/login', [AuthenticationsController::class, 'new'])->name('users.login');
Route::post('/login', [AuthenticationsController::class, 'authenticate'])->name('users.authenticate');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('root');

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
    Route::get('/logout', [AuthenticationsController::class, 'destroy'])->name('users.logout');
});
