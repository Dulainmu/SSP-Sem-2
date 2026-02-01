<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Product Variants Table
        if (!Schema::hasTable('product_variants')) {
            Schema::create('product_variants', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->string('color_name'); // e.g., "Midnight Black"
                $table->string('color_code')->nullable(); // e.g., "#000000"
                $table->string('image_url')->nullable();
                $table->integer('stock_quantity')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Reviews Table
        if (!Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->integer('rating'); // 1-5
                $table->text('comment')->nullable();
                $table->boolean('is_approved')->default(true);
                $table->timestamps();
            });
        }
        
        // Wishlist Table
        if (!Schema::hasTable('wishlist')) {
            Schema::create('wishlist', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->timestamps();
                
                $table->unique(['user_id', 'product_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlist');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('product_variants');
    }
};
