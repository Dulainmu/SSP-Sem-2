@extends('layouts.app')

@section('title', 'My Orders - Celario')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">My Orders</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <ul class="space-y-2">
                    <li><a href="{{ route('profile') }}" class="block px-4 py-2 rounded hover:bg-gray-50">Profile</a></li>
                    <li><a href="{{ route('orders') }}" class="block px-4 py-2 rounded bg-indigo-50 text-indigo-600 font-semibold">Orders</a></li>
                    <li><a href="{{ route('wishlist') }}" class="block px-4 py-2 rounded hover:bg-gray-50">Wishlist</a></li>
                    <li><button onclick="logout()" class="block w-full text-left px-4 py-2 rounded hover:bg-gray-50 text-red-600">Logout</button></li>
                </ul>
            </div>
        </div>

        <!-- Orders List -->
        <div class="lg:col-span-2">
            <div id="orders-container">
                <!-- Orders will be loaded via JavaScript -->
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Load orders
async function loadOrders() {
    if (!authToken) {
        window.location.href = '/login';
        return;
    }
    
    try {
        const response = await fetch(`${API_URL}/orders`, {
            headers: {
                'Authorization': `Bearer ${authToken}`
            }
        });
        
        const data = await response.json();
        
        const container = document.getElementById('orders-container');
        
        // Handle paginated response
        const orders = data.data.data || data.data || [];
        
        if (data.success && orders.length > 0) {
            container.innerHTML = orders.map(order => `
                <div class="bg-white rounded-lg shadow p-6 mb-4">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-bold text-lg">Order #${order.order_number}</h3>
                            <p class="text-sm text-gray-600">Placed on ${new Date(order.created_at).toLocaleDateString()}</p>
                            ${order.user ? `<p class="text-sm text-gray-600">Customer: ${order.user.name} (${order.user.email})</p>` : ''}
                        </div>
                        <div class="text-right">
                            ${order.user ? `
                                <select onchange="updateOrderStatus('${order.id}', this.value)" 
                                        class="mb-2 px-3 py-1 rounded border text-sm font-semibold">
                                    <option value="Pending" ${order.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                    <option value="Processing" ${order.status === 'Processing' ? 'selected' : ''}>Processing</option>
                                    <option value="Shipped" ${order.status === 'Shipped' ? 'selected' : ''}>Shipped</option>
                                    <option value="Delivered" ${order.status === 'Delivered' ? 'selected' : ''}>Delivered</option>
                                    <option value="Cancelled" ${order.status === 'Cancelled' ? 'selected' : ''}>Cancelled</option>
                                </select>
                            ` : `
                                <span class="px-3 py-1 rounded-full text-sm font-semibold ${getStatusColor(order.status)}">
                                    ${order.status}
                                </span>
                            `}
                        </div>
                    </div>
                    
                    <div class="border-t pt-4 space-y-3">
                        ${order.items.map(item => `
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <img src="${item.product.image_url}" alt="${item.product_name}" 
                                         class="w-16 h-16 object-cover rounded">
                                    <div>
                                        <p class="font-medium">${item.product_name}</p>
                                        <p class="text-sm text-gray-500">Qty: ${item.quantity}</p>
                                    </div>
                                </div>
                                <span class="font-semibold">$${(item.price * item.quantity).toFixed(2)}</span>
                            </div>
                        `).join('')}
                    </div>
                    
                    <div class="border-t mt-4 pt-4 flex justify-between items-center">
                        <div>
                            <span class="font-semibold">Total: </span>
                            <span class="text-xl font-bold text-indigo-600">$${parseFloat(order.total_amount).toFixed(2)}</span>
                        </div>
                        <button onclick="viewOrder('${order.order_number}')" 
                                class="text-indigo-600 hover:underline">
                            View Details
                        </button>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = `
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-xl text-gray-500 mb-4">No orders yet</p>
                    <a href="{{ route('shop') }}" class="text-indigo-600 hover:underline">Start Shopping</a>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading orders:', error);
    }
}

function getStatusColor(status) {
    const colors = {
        'Pending': 'bg-yellow-100 text-yellow-800',
        'Processing': 'bg-blue-100 text-blue-800',
        'Shipped': 'bg-purple-100 text-purple-800',
        'Delivered': 'bg-green-100 text-green-800',
        'Cancelled': 'bg-red-100 text-red-800'
    };
    return colors[status] || 'bg-gray-100 text-gray-800';
}

function viewOrder(orderNumber) {
    // In a real app, this would navigate to a detailed order page
    alert('Order details for: ' + orderNumber);
}

async function updateOrderStatus(orderId, newStatus) {
    if (!authToken) {
        alert('Unauthorized');
        return;
    }
    
    try {
        const response = await fetch(`${API_URL}/orders/${orderId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify({ status: newStatus })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Order status updated successfully!');
            loadOrders(); // Reload orders
        } else {
            alert(data.message || 'Failed to update order status');
            loadOrders(); // Reload to reset dropdown
        }
    } catch (error) {
        console.error('Error updating order status:', error);
        alert('Failed to update order status');
        loadOrders();
    }
}

// Load orders on page load
document.addEventListener('DOMContentLoaded', loadOrders);
</script>
@endpush
@endsection
