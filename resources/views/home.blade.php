@extends('layouts.app')

@section('title', 'Cellario - Your Electronics Store')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ asset('images/mainphoto.jpg') }}" alt="Cellario Hero" class="w-full h-full object-cover opacity-20">
    </div>
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/70 to-indigo-900/70"></div>
    <div class="relative max-w-7xl mx-auto px-4 py-24 md:py-32">
        <div class="text-center text-white">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 animate-fade-in-up">
                Find Your Perfect Product Online
            </h1>
            <p class="text-xl md:text-2xl mb-10 text-blue-100 animate-fade-in-up" style="animation-delay: 0.2s;">
                Discover the latest electronics and accessories
            </p>
            <div class="flex gap-4 justify-center animate-fade-in-up" style="animation-delay: 0.4s;">
                <a href="{{ route('shop') }}" class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-blue-50 transition transform hover:scale-105 shadow-lg">
                    Shop Now
                </a>
                <a href="{{ route('about') }}" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white/10 transition">
                    Learn More
                </a>
            </div>
        </div>
    </div>
    <!-- Wave Shape -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
        </svg>
    </div>
</section>

<!-- Product Categories Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">Shop by Category</h2>
            <p class="text-gray-600 text-lg">Explore our wide range of premium electronics</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @php
            $categoryIcons = [
                'Smartphones' => 'smartphoneIcon.png',
                'Laptops' => 'LaptopIcon.png',
                'Headphones' => 'headphoneIcon.png',
                'Smartwatches' => 'smartwatchIcon.png',
                'Tablets' => 'TabletIcon.png'
            ];
            @endphp
            
            @foreach($categories as $category)
            <a href="{{ route('shop', ['category' => $category->id]) }}" 
               class="group relative bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/0 to-indigo-500/0 group-hover:from-blue-500/5 group-hover:to-indigo-500/5 rounded-2xl transition-all duration-300"></div>
                <div class="relative flex flex-col items-center">
                    @php
                    $iconFile = $categoryIcons[$category->name] ?? 'smartphoneIcon.png';
                    @endphp
                    <img src="{{ asset('images/' . $iconFile) }}" 
                         alt="{{ $category->name }}"
                         class="w-24 h-24 object-contain mb-4 group-hover:scale-110 transition-transform duration-300">
                    <p class="text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">{{ $category->name }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="bg-gradient-to-br from-blue-50 to-indigo-50 py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-10">
            <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-5xl">📦</span>
                </div>
                <h4 class="font-bold text-xl mb-3 text-gray-900">Wide Selection</h4>
                <p class="text-gray-600">Choose from the latest laptops, phones, wearables, and more.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-5xl">🛡️</span>
                </div>
                <h4 class="font-bold text-xl mb-3 text-gray-900">Warranty Included</h4>
                <p class="text-gray-600">Enjoy peace of mind with warranty on all major products.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="bg-yellow-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-5xl">⭐</span>
                </div>
                <h4 class="font-bold text-xl mb-3 text-gray-900">Trusted by Thousands</h4>
                <p class="text-gray-600">Join our community of happy gadget lovers and reviewers.</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="max-w-7xl mx-auto px-6 py-20 bg-white">
    <div class="text-center mb-12">
        <h2 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">Featured Products</h2>
        <p class="text-gray-600 text-lg">Discover our most popular and recommended items</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($featuredProducts as $product)
        <div class="bg-white border-2 border-gray-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col group">
            <div class="absolute top-4 right-4 z-10">
                @if($product->compare_price && $product->compare_price > $product->price)
                <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                    -{{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                </span>
                @endif
            </div>
            
            <div class="relative bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 mb-4 group-hover:from-blue-50 group-hover:to-indigo-50 transition-all duration-300">
                @if($product->image_url)
                    <img src="{{ asset($product->image_url) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-32 object-contain group-hover:scale-110 transition-transform duration-300">
                @else
                    <img src="{{ asset('images/placeholder-product.jpg') }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-32 object-contain group-hover:scale-110 transition-transform duration-300">
                @endif
            </div>
            
            <h4 class="font-bold text-lg mb-2 text-gray-900 group-hover:text-blue-600 transition-colors">{{ $product->name }}</h4>
            <p class="text-gray-500 text-sm mb-3">{{ $product->brand->name ?? '' }}</p>
            
            <div class="flex items-center gap-2 mb-4">
                <p class="text-blue-600 font-bold text-xl">${{ number_format($product->price, 2) }}</p>
                @if($product->compare_price && $product->compare_price > $product->price)
                <p class="text-gray-400 text-sm line-through">${{ number_format($product->compare_price, 2) }}</p>
                @endif
            </div>
            
            <div class="flex gap-2 w-full">
                <a href="{{ route('product', $product->id) }}" 
                   class="flex-1 text-center text-sm text-white bg-blue-600 px-3 py-2 rounded hover:bg-blue-700 transition">
                    View Details
                </a>
                @if($product->stock_quantity > 0)
                <button onclick="addToCart({{ $product->id }})" 
                        class="text-sm text-blue-600 border border-blue-600 px-3 py-2 rounded hover:bg-blue-600 hover:text-white transition"
                        title="Add to Cart">
                    <i class="fas fa-cart-plus"></i>
                </button>
                <button onclick="toggleWishlist({{ $product->id }}, this)" 
                        class="text-sm text-red-500 border border-red-500 px-3 py-2 rounded hover:bg-red-500 hover:text-white transition wishlist-btn"
                        data-product-id="{{ $product->id }}"
                        title="Add to Wishlist">
                    <i class="far fa-heart"></i>
                </button>
                @else
                <button disabled class="text-sm text-gray-400 border border-gray-300 px-3 py-2 rounded cursor-not-allowed">
                    <i class="fas fa-times"></i>
                </button>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500 text-lg">No featured products available at the moment.</p>
        </div>
        @endforelse
    </div>
</section>

<!-- Promo Section -->
<section class="bg-black text-white grid md:grid-cols-2 gap-8 max-w-7xl mx-auto px-6 py-12 items-center rounded-xl mb-12">
    <div class="flex justify-center">
        <img src="{{ asset('images/Promoimage02.jpg') }}" class="max-w-md rounded-lg" alt="Promo">
    </div>
    <div>
        <h3 class="text-2xl font-semibold mb-4">Upgrade Your Tech Today!</h3>
        <p class="text-gray-300 mb-6">Discover the latest gadgets at unbeatable prices. Shop now and enjoy exclusive deals on top brands, fast shipping, and expert support.</p>
        <a href="{{ route('shop') }}" class="border border-blue-500 text-blue-500 px-6 py-3 rounded-md hover:bg-blue-500 hover:text-white transition inline-block">
            Shop Now
        </a>
    </div>
</section>

@push('scripts')
<script>
// Load wishlist state on page load
document.addEventListener('DOMContentLoaded', function() {
    if (authToken) {
        loadWishlistState();
    }
});

async function loadWishlistState() {
    try {
        const response = await fetch(`${API_URL}/wishlist`, {
            headers: {
                'Authorization': `Bearer ${authToken}`,
                'Content-Type': 'application/json'
            }
        });
        
        const data = await response.json();
        if (data.success) {
            const wishlistItems = data.wishlist || data.data || [];
            wishlistItems.forEach(item => {
                const btn = document.querySelector(`.wishlist-btn[data-product-id="${item.product_id}"]`);
                if (btn) {
                    btn.classList.add('active');
                    btn.querySelector('i').classList.remove('far');
                    btn.querySelector('i').classList.add('fas');
                }
            });
        }
    } catch (error) {
        console.error('Error loading wishlist:', error);
    }
}

async function toggleWishlist(productId, button) {
    if (!authToken) {
        showNotification('Please login to add items to wishlist', 'error');
        return;
    }

    const icon = button.querySelector('i');
    const isInWishlist = icon.classList.contains('fas');

    try {
        if (isInWishlist) {
            // Remove from wishlist
            const response = await fetch(`${API_URL}/wishlist/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${authToken}`,
                    'Content-Type': 'application/json'
                }
            });
            
            const data = await response.json();
            if (data.success) {
                icon.classList.remove('fas');
                icon.classList.add('far');
                button.classList.remove('active');
                showNotification('Removed from wishlist', 'success');
            }
        } else {
            // Add to wishlist
            const response = await fetch(`${API_URL}/wishlist`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${authToken}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
            });
            
            const data = await response.json();
            if (data.success) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                button.classList.add('active');
                showNotification('Added to wishlist', 'success');
            } else {
                showNotification(data.message || 'Failed to add to wishlist', 'error');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Failed to update wishlist', 'error');
    }
}

async function addToCart(productId) {
    try {
        const response = await fetch(`${API_URL}/cart`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                ...(authToken ? { 'Authorization': `Bearer ${authToken}` } : {})
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification('Product added to cart!', 'success');
            fetchCartCount();
        } else {
            showNotification(data.message || 'Failed to add to cart', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Failed to add to cart', 'error');
    }
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
            ${message}
        </div>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
</script>
@endpush
@endsection
