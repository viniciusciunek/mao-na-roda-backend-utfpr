<?php

require __DIR__ . '/../../config/bootstrap.php';

use Core\Database\Database;
use Database\Populate\AdminsPopulate;
use Database\Populate\BudgetsPopulate;
use Database\Populate\ProductsPopulate;
use Database\Populate\CustomersPopulate;

Database::migrate();

ProductsPopulate::populate();
CustomersPopulate::populate();
AdminsPopulate::populate();
BudgetsPopulate::populate();
