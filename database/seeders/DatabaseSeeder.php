<?php

namespace Database\Seeders;

use App\Models\Shoe;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Brand::factory()->count(10)->create();
        // Category::factory()->count(10)->create();

        Shoe::factory()
            ->count(60) 
            ->create();
    }
}
