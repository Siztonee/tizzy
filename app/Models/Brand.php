<?php

namespace App\Models;

use App\Models\Shoe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $guraded = [];

    public function shoes(): HasMany
    {
        return $this->hasMany(Shoe::class);
    }
}
