<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShoeResource;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Catalog/Index', [
            'shoes' => ShoeResource::collection(Shoe::orderBy('created_at', 'desc')->paginate(21)),
        ]);
    }

    public function loadMoreShoes(Request $request)
    {
        $page = $request->query('page', 1);
        $shoes = Shoe::orderBy('created_at', 'desc')->paginate(21, ['*'], 'page', $page);
        
        return response()->json($shoes);
    }
}
