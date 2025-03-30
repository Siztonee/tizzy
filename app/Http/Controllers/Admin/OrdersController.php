<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function indexOrdersPage()
    {
        return Inertia::render('Admin/Orders');
    }
}
