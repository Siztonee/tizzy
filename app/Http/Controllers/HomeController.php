<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function indexHomePage()
    {
        return Inertia::render('Home');
    }
}
