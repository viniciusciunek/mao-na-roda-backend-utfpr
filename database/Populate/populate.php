<?php

require __DIR__ . '/../../config/bootstrap.php';

use Core\Database\Database;
use Database\Populate\AdminsPopulate;
use Database\Populate\ProductsPopulate;
use Database\Populate\UsersPopulate;

Database::migrate();

ProductsPopulate::populate();
UsersPopulate::populate();
AdminsPopulate::populate();
