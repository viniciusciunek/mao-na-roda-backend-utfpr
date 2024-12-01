<?php

use Core\Router\Route;
use App\Controllers\ProductsController;

Route::get('/', [ProductsController::class, 'index'])->name('root');

// Create
Route::get('/products/new', [ProductsController::class, 'new'])->name('products.new');
Route::post('/products', [ProductsController::class, 'create'])->name('products.create');

// Retrieve
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductsController::class, 'show'])->name('products.show');

// Update
Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductsController::class, 'update'])->name('products.update');

// Delete
Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
