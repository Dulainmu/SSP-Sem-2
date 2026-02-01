<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('product_variants')) {
            Schema::create('product_variants', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->string('color_name');
                $table->string('color_code')->nullable(); // Hex color code like #FF0000
                $table->string('image_url')->nullable();
                $table->decimal('price', 10, 2)->nullable(); // If price varies by color
                $table->integer('stock_quantity')->default(0);
                $table->string('sku')->nullable()->unique();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                
                $table->index(['product_id', 'color_name']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
