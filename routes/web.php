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
    $products = \App\Models\Product::where('status', 'Active')->paginate(12);
    
    return view('shop', compact('categories', 'products'));
})->name('shop');

Route::get('/product/{id?}', function ($id = null) {
    if ($id) {
        $product = \App\Models\Product::with(['category', 'brand'])->findOrFail($id);
    } else {
        $product = \App\Models\Product::with(['category', 'brand'])->first();
    }
    
    // For related products or footer
    $categories = \App\Models\Category::take(5)->get();
    
    return view('product', compact('product', 'categories'));
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
