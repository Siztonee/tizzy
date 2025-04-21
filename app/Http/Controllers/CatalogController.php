<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $shoes = Shoe::orderBy('created_at', 'desc')->paginate(21);
        return Inertia::render('Catalog/Index', compact('shoes'));
    }

    public function loadMoreShoes(Request $request)
    {
        $page = $request->query('page', 1);
        $shoes = Shoe::orderBy('created_at', 'desc')->paginate(21, ['*'], 'page', $page);
        
        return response()->json($shoes);
    }
}
