<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShoeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->when(
                $this->image, 
                fn() => asset('storage/'.$this->image)
            ),
            'description' => $this->description,
            'stock_count' => $this->stock_count,
            'price' => $this->price,
            'discounted_price' => $this->discounted_price,
            'discount_percent' => $this->discount_percent,
            'rating' => $this->rating,
            'is_active' => $this->is_active,
            'discount_dates' => $this->when($this->discount_start, [
                'start' => $this->discount_start?->toIso8601String(),
                'end' => $this->discount_end?->toIso8601String()
            ]),
            'dates' => [
                'created' => $this->created_at?->toIso8601String(),
                'updated' => $this->updated_at?->toIso8601String()
            ]
        ];
    }
}
