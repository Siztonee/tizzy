<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Filters\ProductFilters;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShoeResource;
use App\Http\Requests\CatalogFilterRequest;

class CatalogController extends Controller
{
    public function index(CatalogFilterRequest $request)
    {
        return Inertia::render('Catalog/Index', [
            'shoes' => ShoeResource::collection($this->getFilteredProducts($request)),
            'brands' => Brand::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'filters' => $request->validated()
        ]);
    }

    private function getFilteredProducts($request)
    {
        return Shoe::query()
            ->with('category')
            ->tap(new ProductFilters($request))
            ->paginate(21)
            ->withQueryString();
    }

    public function loadMoreShoes(CatalogFilterRequest $request)
    {
        $shoes = Shoe::query()
            ->with('category')
            ->tap(new ProductFilters($request))
            ->paginate(21);

        return ShoeResource::collection($shoes);
    }
}
