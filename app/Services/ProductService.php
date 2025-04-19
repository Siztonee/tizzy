<?php

namespace App\Services;

use App\Models\Shoe;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function createProduct(array $data, ?UploadedFile $image): Shoe
    {
        if (!$image) {
            throw new \InvalidArgumentException('Изображение обязательно');
        }

        $data['image'] = $this->uploadImage($image);

        if (!empty($data['discount_percent'])) {
            $data['discounted_price'] = $this->calculateDiscount(
                $data['price'], 
                $data['discount_percent']
            );
        }

        return Shoe::create($data);
    }

    protected function uploadImage(UploadedFile $image): string
    {
        return $image->store('public/products');
    }

    protected function calculateDiscount(float $price, float $discountPercent): float
    {
        return round($price * (1 - $discountPercent / 100), 2);
    }
}