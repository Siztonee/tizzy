<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Shoe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $guarded = [];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function shoe(): BelongsTo
    {
        return $this->belongsTo(Shoe::class);
    }
}
