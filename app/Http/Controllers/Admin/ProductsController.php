<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shoe;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShoeResource;

class ProductsController extends Controller
{
    public function indexProductsPage(Request $request)
    {
        $products = Shoe::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        if ($request->expectsJson()) {
            return response()->json($products);
        }
        
        return Inertia::render('Admin/Products', [
            'products' => ShoeResource::collection(Shoe::all())
        ]);
    }
}
