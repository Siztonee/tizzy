<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shoe;
use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use ProductCreationException;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;

class AddProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index()
    {
        $categories = Category::all();
        $brands = Brand::all();

        return Inertia::render('Admin/AddProduct', compact('categories', 'brands'));
    }


    public function store(StoreProductRequest $request, ProductService $productService): RedirectResponse
    {
        try {
            $this->productService->createProduct(
                $request->validated(),
                $request->file('image')
            );

            return redirect()->route('admin.products')->with('success', 'Товар успешно добавлен!');
            
        } catch (ProductCreationException $e) {
            return redirect()
                ->route('admin.products.add')
                ->with('error', 'Ошибка при создании товара: ' . $e->getMessage());
        }
    }
}
