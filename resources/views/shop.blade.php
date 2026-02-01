@extends('layouts.app')

@section('title', 'Shop - Celario')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-2">Our Products</h1>
            <p class="text-blue-100 text-lg">Explore our collection of premium electronics</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-72 flex-shrink-0">
                <div class="bg-white p-6 rounded-2xl shadow-lg sticky top-4">
                    <h3 class="font-bold text-xl mb-6 text-gray-900 flex items-center">
                        <i class="fas fa-filter mr-2 text-blue-600"></i>Filters
                    </h3>
                
                <form action="{{ route('shop') }}" method="GET" id="filterForm">
                    <!-- Categories -->
                    <div class="mb-6 pb-6 border-b">
                        <h4 class="font-semibold mb-3 text-gray-900">Categories</h4>
                        <div class="space-y-2">
                            @foreach($categories as $category)
                                <label class="flex items-center p-2 rounded-lg hover:bg-blue-50 transition cursor-pointer">
                                    <input type="radio" name="category" value="{{ $category->id }}" 
                                           {{ request('category') == $category->id ? 'checked' : '' }}
                                           onchange="this.form.submit()" class="mr-3 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @if(request('category'))
                            <a href="{{ route('shop') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium mt-2 inline-block">
                                <i class="fas fa-times-circle mr-1"></i>Clear
                            </a>
                        @endif
                    </div>

                    <!-- Brands -->
                    <div class="mb-6">
                        <h4 class="font-semibold mb-3 text-gray-900">Brands</h4>
                        <div class="space-y-2">
                            @foreach($brands as $brand)
                                <label class="flex items-center p-2 rounded-lg hover:bg-blue-50 transition cursor-pointer">
                                    <input type="radio" name="brand" value="{{ $brand->id }}" 
                                           {{ request('brand') == $brand->id ? 'checked' : '' }}
                                           onchange="this.form.submit()" class="mr-3 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $brand->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @if(request('brand'))
                            <a href="{{ route('shop') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium mt-2 inline-block">
                                <i class="fas fa-times-circle mr-1"></i>Clear
                            </a>
                        @endif
                    </div>

                    <!-- Hidden field to preserve sort -->
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    
                    <!-- Hidden field to preserve search -->
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                </form>
            </div>
        </div>

            <!-- Products Grid -->
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-gray-700 font-medium">
                        <i class="fas fa-box mr-2 text-blue-600"></i>
                        Showing <span class="font-bold text-blue-600">{{ $products->count() }}</span> of <span class="font-bold">{{ $products->total() }}</span> products
                    </div>
                    <form action="{{ route('shop') }}" method="GET" class="inline-block">
                        <!-- Preserve filters -->
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('brand'))
                            <input type="hidden" name="brand" value="{{ request('brand') }}">
                        @endif
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        
                        <select name="sort" onchange="this.form.submit()" class="border-2 border-gray-200 rounded-xl px-6 py-3 font-medium text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                        <a href="{{ route('product', $product->id) }}" class="block relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 group-hover:from-blue-50 group-hover:to-indigo-50 transition-all duration-300">
                            @if($product->compare_price && $product->compare_price > $product->price)
                                <span class="absolute top-4 right-4 z-10 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                    -{{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                                </span>
                            @endif
                            @if($product->image_url)
                                <img src="{{ asset($product->image_url) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-56 object-contain p-6 group-hover:scale-110 transition-transform duration-300">
                            @else
                                <img src="https://via.placeholder.com/300" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-56 object-contain p-6 group-hover:scale-110 transition-transform duration-300">
                            @endif
                        </a>
                        <div class="p-5">
                            <a href="{{ route('product', $product->id) }}" class="font-semibold text-lg hover:text-indigo-600">
                                {{ $product->name }}
                            </a>
                            <p class="text-gray-600 text-sm mt-1">{{ Str::limit($product->short_description, 60) }}</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-2xl font-bold text-indigo-600">${{ number_format($product->price, 2) }}</span>
                                @if($product->compare_price)
                                    <span class="text-gray-400 line-through">${{ number_format($product->compare_price, 2) }}</span>
                                @endif
                            </div>
                            <div class="flex gap-2 mt-4">
                                <button onclick="addToCart({{ $product->id }})" 
                                        class="flex-1 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                                    Add to Cart
                                </button>
                                <button onclick="toggleWishlist({{ $product->id }}, this)" 
                                        class="text-red-500 border border-red-500 px-3 py-2 rounded-lg hover:bg-red-500 hover:text-white transition wishlist-btn"
                                        data-product-id="{{ $product->id }}"
                                        title="Add to Wishlist">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">No products found.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

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
            data.data.forEach(item => {
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
        alert('Please login to add items to wishlist');
        window.location.href = '/login';
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
                alert('Removed from wishlist');
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
                alert('Added to wishlist');
            } else {
                alert(data.message || 'Failed to add to wishlist');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to update wishlist');
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
            alert('Product added to cart!');
            fetchCartCount();
        } else {
            alert(data.message || 'Failed to add to cart');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to add to cart');
    }
}
</script>
@endpush
@endsection
