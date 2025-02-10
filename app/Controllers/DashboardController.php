<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request): void
    {
        $title = 'Dashboard';

        $this->render('dashboard/index', compact('title'));
    }
}
