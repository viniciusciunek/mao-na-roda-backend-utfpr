<?php

use Core\Router\Route;
use App\Controllers\ProductsController;

Route::get('/',             [ProductsController::class, 'index'])->name('root');
Route::get('/products',             [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/new', [ProductsController::class, 'new'])->name('products.new');

Route::post('/products', [ProductsController::class, 'create'])->name('products.create');
