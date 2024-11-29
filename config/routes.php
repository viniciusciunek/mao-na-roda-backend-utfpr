<?php

use Core\Router\Route;
use App\Controllers\ProductsController;

Route::get('/',             [ProductsController::class, 'index']);
Route::get('/products',             [ProductsController::class, 'index']);
Route::get('/products/new', [ProductsController::class, 'new']);
