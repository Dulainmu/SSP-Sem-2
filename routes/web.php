<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FirebaseUploadTestController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Firebase test routes (remove in production)
Route::get('/test-firebase', [FirebaseUploadTestController::class, 'showForm']);
Route::post('/test-upload', [FirebaseUploadTestController::class, 'uploadSingle']);

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/product/{id}', [HomeController::class, 'product'])->name('product');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Auth routes
Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthWebController::class, 'showRegister'])->name('register');
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

// Redirect after login based on role
Route::get('/redirect-after-login', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'Admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('shop');
    }
    return redirect()->route('login');
})->middleware('auth:sanctum')->name('redirect.after.login');

// Protected routes
Route::middleware(['auth:sanctum', 'check.user.status'])->group(function () {
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile');
    Route::get('/orders', [AuthWebController::class, 'orders'])->name('orders');
    Route::get('/wishlist', [AuthWebController::class, 'wishlist'])->name('wishlist');
    
    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    
    // Categories
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    
    // Customers
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{customer}', [AdminCustomerController::class, 'show'])->name('customers.show');
    Route::post('/customers/{customer}/toggle-block', [AdminCustomerController::class, 'toggleBlock'])->name('customers.toggleBlock');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'Admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('shop');
    })->name('dashboard');
});
