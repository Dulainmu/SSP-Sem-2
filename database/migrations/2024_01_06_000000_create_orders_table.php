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
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_number')->unique();
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
                $table->enum('status', ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled', 'Refunded'])->default('Pending');
                $table->string('currency', 3)->default('USD');
                $table->decimal('subtotal', 10, 2);
                $table->decimal('tax_amount', 10, 2)->default(0);
                $table->decimal('shipping_amount', 10, 2)->default(0);
                $table->decimal('discount_amount', 10, 2)->default(0);
                $table->decimal('total_amount', 10, 2);
                $table->enum('payment_method', ['Credit Card', 'PayPal', 'Bank Transfer', 'Cash on Delivery'])->default('Credit Card');
                $table->enum('payment_status', ['Pending', 'Paid', 'Failed', 'Refunded'])->default('Pending');
                $table->string('shipping_method')->nullable();
                $table->string('tracking_number')->nullable();
                $table->text('notes')->nullable();
                
                // Billing
                $table->string('billing_first_name')->nullable();
                $table->string('billing_last_name')->nullable();
                $table->string('billing_company')->nullable();
                $table->string('billing_address_1')->nullable();
                $table->string('billing_address_2')->nullable();
                $table->string('billing_city')->nullable();
                $table->string('billing_state')->nullable();
                $table->string('billing_postal_code')->nullable();
                $table->string('billing_country')->nullable();
                $table->string('billing_email')->nullable();
                $table->string('billing_phone')->nullable();

                // Shipping
                $table->string('shipping_first_name')->nullable();
                $table->string('shipping_last_name')->nullable();
                $table->string('shipping_company')->nullable();
                $table->string('shipping_address_1')->nullable();
                $table->string('shipping_address_2')->nullable();
                $table->string('shipping_city')->nullable();
                $table->string('shipping_state')->nullable();
                $table->string('shipping_postal_code')->nullable();
                $table->string('shipping_country')->nullable();

                $table->timestamp('order_date')->useCurrent();
                $table->timestamp('shipped_date')->nullable();
                $table->timestamp('delivered_date')->nullable();
                $table->timestamps();

                $table->index('user_id');
                $table->index('status');
                $table->index('order_date');
                $table->index('total_amount');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
