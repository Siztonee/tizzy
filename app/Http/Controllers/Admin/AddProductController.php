<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/AddProduct');
    }
}
