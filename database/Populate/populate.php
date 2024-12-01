<?php

require __DIR__ . '/../../config/bootstrap.php';

use Core\Database\Database;
use Database\Populate\ProductsPopulate;

Database::migrate();

ProductsPopulate::populate();
