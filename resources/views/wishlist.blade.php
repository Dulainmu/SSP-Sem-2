@extends('layouts.app')

@section('title', 'My Wishlist - Celario')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">My Wishlist</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <ul class="space-y-2">
                    <li><a href="{{ route('profile') }}" class="block px-4 py-2 rounded hover:bg-gray-50">Profile</a></li>
                    <li><a href="{{ route('orders') }}" class="block px-4 py-2 rounded hover:bg-gray-50">Orders</a></li>
                    <li><a href="{{ route('wishlist') }}" class="block px-4 py-2 rounded bg-indigo-50 text-indigo-600 font-semibold">Wishlist</a></li>
                    <li><button onclick="logout()" class="block w-full text-left px-4 py-2 rounded hover:bg-gray-50 text-red-600">Logout</button></li>
                </ul>
            </div>
        </div>

        <!-- Wishlist Items -->
        <div class="lg:col-span-2">
            <div id="wishlist-container" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Wishlist items will be loaded via JavaScript -->
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Load wishlist
async function loadWishlist() {
    if (!authToken) {
        window.location.href = '/login';
        return;
    }
    
    try {
        const response = await fetch(`${API_URL}/wishlist`, {
            headers: {
                'Authorization': `Bearer ${authToken}`
            }
        });
        
        const data = await response.json();
        
        const container = document.getElementById('wishlist-container');
        
        if (data.success && data.wishlist.length > 0) {
            container.innerHTML = data.wishlist.map(item => `
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <a href="/product/${item.product.id}">
                        <img src="${item.product.image_url ? item.product.image_url : 'https://via.placeholder.com/300'}" 
                             alt="${item.product.name}" 
                             class="w-full h-48 object-cover">
                    </a>
                    <div class="p-4">
                        <a href="/product/${item.product.id}" class="font-semibold text-lg hover:text-indigo-600">
                            ${item.product.name}
                        </a>
                        <p class="text-gray-600 text-sm mt-1">${item.product.short_description || ''}</p>
                        <div class="mt-4">
                            <span class="text-2xl font-bold text-indigo-600">$${parseFloat(item.product.price).toFixed(2)}</span>
                        </div>
                        <div class="mt-4 flex gap-2">
                            <button onclick="addToCart(${item.product.id})" 
                                    class="flex-1 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                                Add to Cart
                            </button>
                            <button onclick="removeFromWishlist(${item.product_id})" 
                                    class="px-4 border-2 border-red-500 text-red-500 rounded-lg hover:bg-red-50">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = `
                <div class="col-span-full bg-white rounded-lg shadow p-12 text-center">
                    <i class="far fa-heart text-gray-300 text-8xl mb-4"></i>
                    <p class="text-xl text-gray-500 mb-4">Your wishlist is empty</p>
                    <a href="{{ route('shop') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">Browse Products</a>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading wishlist:', error);
    }
}

// Add to cart
async function addToCart(productId) {
    try {
        const response = await fetch(`${API_URL}/cart`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
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

// Remove from wishlist
async function removeFromWishlist(productId) {
    if (!confirm('Remove this item from wishlist?')) return;
    
    try {
        const response = await fetch(`${API_URL}/wishlist/${productId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${authToken}`
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Removed from wishlist');
            loadWishlist();
        } else {
            alert(data.message || 'Failed to remove item');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to remove item');
    }
}

// Load wishlist on page load
document.addEventListener('DOMContentLoaded', loadWishlist);
</script>
@endpush
@endsection
