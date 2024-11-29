<?php

require '/var/www/config/bootstrap.php';

use App\Controllers\ProductsController;

$controller = new ProductsController();
$controller->show();
