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
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->text('short_description')->nullable();
                $table->string('sku')->unique()->nullable();
                $table->string('barcode')->nullable();
                $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
                $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
                $table->decimal('price', 10, 2);
                $table->decimal('compare_price', 10, 2)->nullable();
                $table->decimal('cost_price', 10, 2)->nullable();
                $table->integer('stock_quantity')->default(0);
                $table->integer('min_stock_level')->default(5);
                $table->decimal('weight', 8, 2)->nullable();
                $table->string('dimensions')->nullable();
                $table->string('image_url')->nullable();
                $table->json('gallery')->nullable();
                $table->boolean('is_featured')->default(false);
                $table->boolean('is_digital')->default(false);
                $table->boolean('requires_shipping')->default(true);
                $table->string('tax_status')->default('taxable');
                $table->string('tax_class')->nullable();
                $table->enum('status', ['Draft', 'Active', 'Archived'])->default('Draft');
                $table->enum('visibility', ['Visible', 'Hidden'])->default('Visible');
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->timestamps();

                $table->index('category_id');
                $table->index('brand_id');
                $table->index('sku');
                $table->index('status');
                $table->index('is_featured');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
