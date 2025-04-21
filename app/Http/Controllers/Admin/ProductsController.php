<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shoe;
use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShoeResource;
use App\Http\Requests\StoreProductRequest;

class ProductsController extends Controller
{
    public function __construct(private ProductService $productService) {}


    public function index(Request $request)
    {
        $products = Shoe::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        if ($request->expectsJson()) {
            return response()->json($products);
        }
        
        return Inertia::render('Admin/Products/Index', [
            'products' => ShoeResource::collection(Shoe::all())
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();

        return Inertia::render('Admin/Products/Create', compact('categories', 'brands'));
    }

    public function store(StoreProductRequest $request, ProductService $productService)
    {
        try {
            $this->productService->createProduct(
                $request->validated(),
                $request->file('image')
            );

            return redirect()->route('admin.products')->with('success', 'Товар успешно добавлен!');
            
        } catch (ProductCreationException $e) {
            return redirect()
                ->route('admin.products.create')
                ->with('error', 'Ошибка при создании товара: ' . $e->getMessage());
        }
    }
}
