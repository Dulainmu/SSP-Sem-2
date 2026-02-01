@extends('layouts.app')

@section('title', 'Shopping Cart - Celario')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div id="cart-items" class="space-y-4">
                <!-- Cart items will be loaded via JavaScript -->
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-lg sticky top-4">
                <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span id="subtotal">$0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping</span>
                        <span id="shipping">$0.00</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t pt-3">
                        <span>Total</span>
                        <span id="total">$0.00</span>
                    </div>
                </div>

                <!-- Coupon Code -->
                <div class="mb-4">
                    <input type="text" id="coupon-code" placeholder="Enter coupon code" 
                           class="w-full border rounded-lg px-3 py-2 mb-2">
                    <button onclick="applyCoupon()" 
                            class="w-full border border-indigo-600 text-indigo-600 py-2 rounded-lg hover:bg-indigo-50">
                        Apply Coupon
                    </button>
                    <div id="coupon-message" class="text-sm mt-2"></div>
                </div>

                <a href="{{ route('checkout') }}" 
                   class="block w-full bg-indigo-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-indigo-700">
                    Proceed to Checkout
                </a>
                <a href="{{ route('shop') }}" 
                   class="block w-full text-center mt-4 text-indigo-600 hover:underline">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let cartItems = [];
let appliedCoupon = null;

// Load cart items
async function loadCart() {
    try {
        const response = await fetch(`${API_URL}/cart`, {
            headers: authToken ? { 'Authorization': `Bearer ${authToken}` } : {}
        });
        const data = await response.json();
        
        if (data.success) {
            cartItems = data.data.items || [];
            renderCart();
            updateSummary();
        }
    } catch (error) {
        console.error('Error loading cart:', error);
    }
}

// Render cart items
function renderCart() {
    const container = document.getElementById('cart-items');
    
    if (cartItems.length === 0) {
        container.innerHTML = `
            <div class="text-center py-12">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <p class="text-xl text-gray-500 mb-4">Your cart is empty</p>
                <a href="{{ route('shop') }}" class="text-indigo-600 hover:underline">Start Shopping</a>
            </div>
        `;
        return;
    }
    
    container.innerHTML = cartItems.map(item => `
        <div class="bg-white p-4 rounded-lg shadow flex gap-4">
            <img src="${item.product.image_url || 'https://via.placeholder.com/100'}" 
                 alt="${item.product.name}" 
                 class="w-24 h-24 object-cover rounded">
            <div class="flex-1">
                <h3 class="font-semibold text-lg">${item.product.name}</h3>
                <p class="text-gray-600">$${parseFloat(item.product.price).toFixed(2)}</p>
                <div class="mt-2 flex items-center gap-2">
                    <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" 
                            class="px-3 py-1 border rounded hover:bg-gray-100">-</button>
                    <span class="px-4">${item.quantity}</span>
                    <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})" 
                            class="px-3 py-1 border rounded hover:bg-gray-100">+</button>
                </div>
            </div>
            <div class="text-right">
                <div class="font-bold text-lg mb-2">$${(item.product.price * item.quantity).toFixed(2)}</div>
                <button onclick="removeItem(${item.id})" 
                        class="text-red-600 hover:text-red-800 text-sm">Remove</button>
            </div>
        </div>
    `).join('');
}

// Update quantity
async function updateQuantity(itemId, quantity) {
    if (quantity < 1) return;
    
    try {
        const response = await fetch(`${API_URL}/cart/${itemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                ...(authToken ? { 'Authorization': `Bearer ${authToken}` } : {})
            },
            body: JSON.stringify({ quantity })
        });
        
        const data = await response.json();
        
        if (data.success) {
            await loadCart();
        } else {
            alert(data.message || 'Failed to update quantity');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to update quantity');
    }
}

// Remove item
async function removeItem(itemId) {
    if (!confirm('Remove this item from cart?')) return;
    
    try {
        const response = await fetch(`${API_URL}/cart/${itemId}`, {
            method: 'DELETE',
            headers: authToken ? { 'Authorization': `Bearer ${authToken}` } : {}
        });
        
        const data = await response.json();
        
        if (data.success) {
            await loadCart();
            fetchCartCount();
        } else {
            alert(data.message || 'Failed to remove item');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to remove item');
    }
}

// Apply coupon
async function applyCoupon() {
    const code = document.getElementById('coupon-code').value;
    if (!code) return;
    
    try {
        const response = await fetch(`${API_URL}/coupon/validate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                ...(authToken ? { 'Authorization': `Bearer ${authToken}` } : {})
            },
            body: JSON.stringify({ code })
        });
        
        const data = await response.json();
        const messageEl = document.getElementById('coupon-message');
        
        if (data.success) {
            appliedCoupon = data.data;
            messageEl.innerHTML = `<span class="text-green-600">Coupon applied! ${appliedCoupon.discount_type === 'percentage' ? appliedCoupon.discount_value + '%' : '$' + appliedCoupon.discount_value} off</span>`;
            updateSummary();
        } else {
            messageEl.innerHTML = `<span class="text-red-600">${data.message}</span>`;
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Update order summary
function updateSummary() {
    const subtotal = cartItems.reduce((sum, item) => sum + (item.product.price * item.quantity), 0);
    const shipping = subtotal > 0 ? 10 : 0; // Flat $10 shipping
    
    let discount = 0;
    if (appliedCoupon) {
        if (appliedCoupon.discount_type === 'percentage') {
            discount = subtotal * (appliedCoupon.discount_value / 100);
        } else {
            discount = appliedCoupon.discount_value;
        }
    }
    
    const total = subtotal + shipping - discount;
    
    document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('shipping').textContent = '$' + shipping.toFixed(2);
    document.getElementById('total').textContent = '$' + Math.max(0, total).toFixed(2);
}

// Load cart on page load
document.addEventListener('DOMContentLoaded', loadCart);
</script>
@endpush
@endsection
