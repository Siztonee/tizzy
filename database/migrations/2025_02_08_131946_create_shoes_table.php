<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shoes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('brand_id')
                ->constrained('brands')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image');
            $table->text('description');

            $table->unsignedInteger('stock_count');

            $table->decimal('price', 8, 2);
            $table->decimal('discounted_price', 8, 2)->nullable();
            $table->unsignedTinyInteger('discount_percent')->nullable();

            $table->decimal('rating', 2, 1)->default(0); 
            $table->boolean('is_active')->default(true);

            $table->timestamp('discount_start')->nullable();
            $table->timestamp('discount_end')->nullable();
            $table->timestamps();

            $table->index('price');
            $table->index('rating');
            $table->index('is_active');
            $table->index('discounted_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shoes');
    }
};
