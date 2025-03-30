<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shoe extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price' => 'integer',
        'discounted_price' => 'integer',
        'discount_percent' => 'integer',
        'rating' => 'decimal:1',
        'active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function getDiscountPriceAttribute()
    {
        return number_format($this->attributes['discount_price'], 0, '', ' ');
    }

    public function getPriceAttribute()
    {
        return number_format($this->attributes['price'], 0, '', ' ');
    }
}
