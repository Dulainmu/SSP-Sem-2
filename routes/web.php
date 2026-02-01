<?php

use Illuminate\Support\Facades\Route;

// Public Pages
Route::get('/', function () {
    $categories = \App\Models\Category::where('is_active', true)->take(5)->get();
    $featuredProducts = \App\Models\Product::where('is_featured', true)->where('status', 'Active')->take(8)->get();
    
    return view('home', compact('categories', 'featuredProducts'));
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/shop', function () {
    $categories = \App\Models\Category::where('is_active', true)->get();
    $brands = \App\Models\Brand::all(); // Fetch all brands
    $products = \App\Models\Product::where('status', 'Active')->paginate(12);
    
    return view('shop', compact('categories', 'brands', 'products'));
})->name('shop');

Route::get('/product/{id?}', function ($id = null) {
    if ($id) {
        $product = \App\Models\Product::with(['category', 'brand', 'variants', 'reviews'])->findOrFail($id);
    } else {
        $product = \App\Models\Product::with(['category', 'brand', 'variants', 'reviews'])->firstOrFail();
    }
    
    // Fetch related products (same category, excluding current)
    $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->take(4)
        ->get();
    
    // For related products or footer
    $categories = \App\Models\Category::take(5)->get();
    
    return view('product', compact('product', 'categories', 'relatedProducts'));
})->name('product');

Route::get('/cart', function () {
    $categories = \App\Models\Category::take(5)->get();
    return view('cart', compact('categories'));
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/wishlist', function () {
    return view('wishlist');
})->name('wishlist');

Route::get('/orders', function () {
    return view('orders');
})->name('orders');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Temporary Debug Route
Route::get('/debug-db', function () {
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        $dbName = \Illuminate\Support\Facades\DB::connection()->getDatabaseName();
        $tableCount = count(\Illuminate\Support\Facades\DB::select('SHOW TABLES'));
        
        return "Database Connected successfully to '{$dbName}'. Tables found: {$tableCount}.";
    } catch (\Exception $e) {
        return "Database Connection Failed: " . $e->getMessage();
    }
});
