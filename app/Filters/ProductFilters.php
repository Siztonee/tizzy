<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ProductFilters
{
    public function __construct(protected Request $request) {}

    public function __invoke($query)
    {
        return $this->applyFilters($query);
    }

    protected function applyFilters($query)
    {
        foreach ($this->filters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($query, $value);
            }
        }
        return $query;
    }

    protected function filters()
    {
        return $this->request->validated();
    }

    protected function category($query, $value)
    {
        $query->where('category_id', $value);
    }

    protected function brand($query, $value)
    {
        $query->where('brand_id', $value);
    }

    protected function categories($query, $value)
    {
        $query->whereIn('category_id', $value);
    }

    protected function brands($query, $value)
    {
        $query->whereIn('brand_id', $value);
    }

    protected function min_price($query, $value)
    {
        $query->where('price', '>=', $value);
    }

    protected function max_price($query, $value)
    {
        $query->where('price', '<=', $value);
    }

    protected function discount($query, $value)
    {
        $query->where('discount_percent', '>=', $value);
    }
}