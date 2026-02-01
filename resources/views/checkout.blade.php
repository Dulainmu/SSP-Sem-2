@extends('layouts.app')

@section('title', 'Checkout - Celario')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Checkout</h1>
        <a href="{{ route('cart') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>Back to Cart
        </a>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <div class="lg:col-span-2">
            <form id="checkout-form" onsubmit="placeOrder(event)" class="space-y-6">
                <!-- Billing Information -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold mb-4">Billing Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium">First Name *</label>
                            <input type="text" name="billing_first_name" required 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">Last Name *</label>
                            <input type="text" name="billing_last_name" required 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium">Email *</label>
                            <input type="email" name="billing_email" required 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium">Phone *</label>
                            <input type="tel" name="billing_phone" required 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium">Address *</label>
                            <input type="text" name="billing_address_1" required 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">City *</label>
                            <input type="text" name="billing_city" required 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">State *</label>
                            <input type="text" name="billing_state" required 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">Zip Code *</label>
                            <input type="text" name="billing_postal_code" required 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">Country *</label>
                            <input type="text" name="billing_country" required 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Shipping Information</h2>
                        <label class="flex items-center">
                            <input type="checkbox" id="same-as-billing" checked 
                                   onchange="toggleShipping()"
                                   class="mr-2">
                            <span class="text-sm">Same as billing</span>
                        </label>
                    </div>
                    <div id="shipping-fields" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium">First Name</label>
                            <input type="text" name="shipping_first_name" 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">Last Name</label>
                            <input type="text" name="shipping_last_name" 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-medium">Address</label>
                            <input type="text" name="shipping_address_1" 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">City</label>
                            <input type="text" name="shipping_city" 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">State</label>
                            <input type="text" name="shipping_state" 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">Zip Code</label>
                            <input type="text" name="shipping_postal_code" 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">Country</label>
                            <input type="text" name="shipping_country" 
                                   class="w-full border rounded-lg px-3 py-2">
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold mb-4">Payment Method</h2>
                    <div class="space-y-3">
                        <label class="flex items-center border p-4 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="Credit Card" checked class="mr-3">
                            <span>Credit Card</span>
                        </label>
                        <label class="flex items-center border p-4 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="PayPal" class="mr-3">
                            <span>PayPal</span>
                        </label>
                        <label class="flex items-center border p-4 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="Cash on Delivery" class="mr-3">
                            <span>Cash on Delivery</span>
                        </label>
                    </div>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-lg sticky top-4">
                <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                
                <div id="order-items" class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                    <!-- Items will be loaded via JavaScript -->
                </div>

                <div class="space-y-3 mb-4 border-t pt-4">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span id="subtotal">$0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping</span>
                        <span id="shipping">$0.00</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span id="total">$0.00</span>
                    </div>
                </div>

                <button type="submit" form="checkout-form" 
                        class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                    Place Order
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let cartItems = [];

// Toggle shipping fields
function toggleShipping() {
    const checkbox = document.getElementById('same-as-billing');
    const fields = document.getElementById('shipping-fields');
    fields.classList.toggle('hidden', checkbox.checked);
}

// Load cart items
async function loadCart() {
    try {
        const response = await fetch(`${API_URL}/cart`, {
            headers: authToken ? { 'Authorization': `Bearer ${authToken}` } : {}
        });
        const data = await response.json();
        
        if (data.success) {
            cartItems = data.data.items || [];
            renderOrderSummary();
        }
    } catch (error) {
        console.error('Error loading cart:', error);
    }
}

// Render order summary
function renderOrderSummary() {
    const container = document.getElementById('order-items');
    
    container.innerHTML = cartItems.map(item => `
        <div class="flex items-center justify-between text-sm border-b pb-3">
            <div class="flex items-center space-x-3">
                <img src="${item.product.image_url}" alt="${item.product.name}" 
                     class="w-16 h-16 object-cover rounded">
                <div>
                    <p class="font-medium">${item.product.name}</p>
                    <p class="text-gray-500">Qty: ${item.quantity}</p>
                </div>
            </div>
            <span class="font-semibold">$${(item.product.price * item.quantity).toFixed(2)}</span>
        </div>
    `).join('');
    
    const subtotal = cartItems.reduce((sum, item) => sum + (item.product.price * item.quantity), 0);
    const shipping = 10;
    const total = subtotal + shipping;
    
    document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('shipping').textContent = '$' + shipping.toFixed(2);
    document.getElementById('total').textContent = '$' + total.toFixed(2);
}

// Place order
async function placeOrder(event) {
    event.preventDefault();
    
    if (!authToken) {
        alert('Please login to place an order');
        window.location.href = '/login';
        return;
    }
    
    const form = event.target;
    const formData = new FormData(form);
    const sameAsBilling = document.getElementById('same-as-billing').checked;
    
    const orderData = {
        billing_first_name: formData.get('billing_first_name'),
        billing_last_name: formData.get('billing_last_name'),
        billing_email: formData.get('billing_email'),
        billing_phone: formData.get('billing_phone'),
        billing_address_1: formData.get('billing_address_1'),
        billing_city: formData.get('billing_city'),
        billing_state: formData.get('billing_state'),
        billing_postal_code: formData.get('billing_postal_code'),
        billing_country: formData.get('billing_country'),
        shipping_first_name: sameAsBilling ? formData.get('billing_first_name') : formData.get('shipping_first_name'),
        shipping_last_name: sameAsBilling ? formData.get('billing_last_name') : formData.get('shipping_last_name'),
        shipping_address_1: sameAsBilling ? formData.get('billing_address_1') : formData.get('shipping_address_1'),
        shipping_city: sameAsBilling ? formData.get('billing_city') : formData.get('shipping_city'),
        shipping_state: sameAsBilling ? formData.get('billing_state') : formData.get('shipping_state'),
        shipping_postal_code: sameAsBilling ? formData.get('billing_postal_code') : formData.get('shipping_postal_code'),
        shipping_country: sameAsBilling ? formData.get('billing_country') : formData.get('shipping_country'),
        shipping_method: 'Standard Shipping',
        payment_method: formData.get('payment_method')
    };
    
    try {
        const response = await fetch(`${API_URL}/orders`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify(orderData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Order placed successfully!');
            window.location.href = '/orders';
        } else {
            // Show detailed validation errors if available
            if (data.errors) {
                const errorMessages = Object.values(data.errors).flat().join('\n');
                alert('Validation errors:\n' + errorMessages);
            } else {
                alert(data.message || 'Failed to place order');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to place order: ' + error.message);
    }
}

// Load cart on page load
document.addEventListener('DOMContentLoaded', loadCart);
</script>
@endpush
@endsection
