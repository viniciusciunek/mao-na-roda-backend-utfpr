<?php

namespace App\Controllers;

use App\Models\Customer;
use App\Models\Admin;
use Core\Http\Controllers\Controller;
use Core\Http\Request;
use Lib\Authentication\Auth;

class DashboardController extends Controller
{
    public function index(Request $request): void
    {
        $title = 'Dashboard';

        $this->render('dashboard/index', compact('title'));
    }
}
