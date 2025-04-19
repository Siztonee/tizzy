<?php

namespace Database\Seeders;

use App\Models\Shoe;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShoeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $brands = Brand::all();
        // $categories = Category::all();
        
        // foreach ($brands as $brand) {
        //     for ($i = 0; $i < 5; $i++) {
        //         $category = $categories->random();
                
        //         Shoe::factory()->create([
        //             'brand_id' => $brand->id,
        //             'category_id' => $category->id
        //         ]);
        //     }
        // }
    }
}