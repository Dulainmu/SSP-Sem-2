<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@celario.com',
            'password' => Hash::make('admin123'),
            'user_role' => 'Admin',
            'status' => 'Active',
        ]);

        // Create Test Customer
        User::create([
            'name' => 'John Doe',
            'email' => 'customer@example.com',
            'password' => Hash::make('password123'),
            'user_role' => 'Customer',
            'status' => 'Active',
            'phone' => '123-456-7890',
            'address' => '123 Main St',
            'city' => 'New York',
            'state' => 'NY',
            'postal_code' => '10001',
        ]);

        // Create Categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'description' => 'Electronic devices and accessories',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $phones = Category::create([
            'name' => 'Smartphones',
            'description' => 'Mobile phones and accessories',
            'parent_id' => $electronics->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $laptops = Category::create([
            'name' => 'Laptops',
            'description' => 'Laptop computers',
            'parent_id' => $electronics->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $clothing = Category::create([
            'name' => 'Clothing',
            'description' => 'Fashion and apparel',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // Create Brands
        $apple = Brand::create([
            'name' => 'Apple',
            'description' => 'Apple Inc. - Technology company',
            'website_url' => 'https://apple.com',
            'is_active' => true,
        ]);

        $samsung = Brand::create([
            'name' => 'Samsung',
            'description' => 'Samsung Electronics',
            'website_url' => 'https://samsung.com',
            'is_active' => true,
        ]);

        $dell = Brand::create([
            'name' => 'Dell',
            'description' => 'Dell Technologies',
            'website_url' => 'https://dell.com',
            'is_active' => true,
        ]);

        // Create Products
        // Product::create([
        //     'name' => 'iPhone 15 Pro',
        //     'description' => 'Latest iPhone with A17 Pro chip, titanium design, and advanced camera system',
        //     'short_description' => 'Premium smartphone with cutting-edge features',
        //     'sku' => 'IPH-15-PRO-256',
        //     'category_id' => $phones->id,
        //     'brand_id' => $apple->id,
        //     'price' => 999.99,
        //     'compare_price' => 1099.99,
        //     'stock_quantity' => 50,
        //     'image_url' => '/uploads/products/img_68db191f3b0754.71697867.jpg',
        //     'is_featured' => true,
        //     'status' => 'Active',
        // ]);

        // Product::create([
        //     'name' => 'Samsung Galaxy S24 Ultra',
        //     'description' => 'Flagship Android phone with S Pen, powerful camera, and stunning display',
        //     'short_description' => 'Ultimate Android flagship phone',
        //     'sku' => 'SAM-S24-ULTRA-512',
        //     'category_id' => $phones->id,
        //     'brand_id' => $samsung->id,
        //     'price' => 1199.99,
        //     'compare_price' => 1299.99,
        //     'stock_quantity' => 30,
        //     'image_url' => '/uploads/products/img_68db71b3bff2d2.60510097.jpg',
        //     'is_featured' => true,
        //     'status' => 'Active',
        // ]);

        // Product::create([
        //     'name' => 'Dell XPS 15',
        //     'description' => 'Premium laptop with Intel i7, 16GB RAM, 512GB SSD, and 15.6" 4K display',
        //     'short_description' => 'High-performance laptop for professionals',
        //     'sku' => 'DELL-XPS15-I7-16-512',
        //     'category_id' => $laptops->id,
        //     'brand_id' => $dell->id,
        //     'price' => 1499.99,
        //     'compare_price' => 1699.99,
        //     'stock_quantity' => 20,
        //     'image_url' => '/uploads/products/img_68dbb58ab189c0.87702110.jpg',
        //     'is_featured' => true,
        //     'status' => 'Active',
        //     'visibility' => 'Visible',
        // ]);

        // Product::create([
        //     'name' => 'MacBook Air M2',
        //     'description' => 'Thin and light laptop with Apple M2 chip, 8GB RAM, 256GB SSD',
        //     'short_description' => 'Ultra-portable laptop with M2 chip',
        //     'sku' => 'MBA-M2-8-256',
        //     'category_id' => $laptops->id,
        //     'brand_id' => $apple->id,
        //     'price' => 1099.99,
        //     'stock_quantity' => 40,
        //     'is_featured' => false,
        //     'status' => 'Active',
        // ]);

        // Product::create([
        //     'name' => 'Samsung Galaxy Tab S9',
        //     'description' => 'Premium Android tablet with S Pen and 11" display',
        //     'short_description' => 'Versatile Android tablet',
        //     'sku' => 'SAM-TAB-S9-128',
        //     'category_id' => $electronics->id,
        //     'brand_id' => $samsung->id,
        //     'price' => 799.99,
        //     'stock_quantity' => 25,
        //     'is_featured' => false,
        //     'status' => 'Active',
        // ]);

        // Create Coupons
        Coupon::create([
            'code' => 'WELCOME10',
            'type' => 'Percentage',
            'amount' => 10,
            'minimum_amount' => 50,
            'usage_limit' => 100,
            'used_count' => 0,
            'expires_at' => now()->addMonths(3),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'SAVE20',
            'type' => 'Fixed Amount',
            'amount' => 20,
            'minimum_amount' => 100,
            'usage_limit' => 50,
            'used_count' => 0,
            'expires_at' => now()->addMonths(2),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'FREESHIP',
            'type' => 'Free Shipping',
            'amount' => 0,
            'minimum_amount' => 75,
            'usage_limit' => null,
            'used_count' => 0,
            'expires_at' => null,
            'is_active' => true,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin credentials: admin@celario.com / admin123');
        $this->command->info('Customer credentials: customer@example.com / password123');
    }
}

