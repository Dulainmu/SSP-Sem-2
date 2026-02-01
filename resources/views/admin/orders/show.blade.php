@extends('layouts.admin')

@section('title', 'Order Details - Admin Panel')
@section('page-title', 'Order #' . $order->order_number)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Items -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold">Order Items</h3>
            </div>
            <div class="p-6">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2 text-sm font-medium text-gray-600">Product</th>
                            <th class="text-left py-2 text-sm font-medium text-gray-600">Price</th>
                            <th class="text-left py-2 text-sm font-medium text-gray-600">Quantity</th>
                            <th class="text-left py-2 text-sm font-medium text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr class="border-b">
                            <td class="py-3">
                                <div class="flex items-center">
                                    @if($item->product)
                                    <img src="{{ $item->product->image_url ? asset($item->product->image_url) : 'https://via.placeholder.com/60' }}" 
                                         alt="{{ $item->product_name }}" 
                                         class="w-12 h-12 object-cover rounded mr-3">
                                    @endif
                                    <span class="text-sm">{{ $item->product_name }}</span>
                                </div>
                            </td>
                            <td class="py-3 text-sm">${{ number_format($item->price, 2) }}</td>
                            <td class="py-3 text-sm">{{ $item->quantity }}</td>
                            <td class="py-3 text-sm font-medium">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-semibold">
                            <td colspan="3" class="py-3 text-right">Subtotal:</td>
                            <td class="py-3">${{ number_format($order->subtotal_amount, 2) }}</td>
                        </tr>
                        @if($order->discount_amount > 0)
                        <tr class="text-green-600">
                            <td colspan="3" class="py-1 text-right">Discount:</td>
                            <td class="py-1">-${{ number_format($order->discount_amount, 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="3" class="py-1 text-right">Shipping:</td>
                            <td class="py-1">${{ number_format($order->shipping_amount, 2) }}</td>
                        </tr>
                        <tr class="font-bold text-lg">
                            <td colspan="3" class="py-3 text-right">Total:</td>
                            <td class="py-3">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Order Details -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Customer Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
            <div class="space-y-2 text-sm">
                <p><strong>Name:</strong> {{ $order->billing_first_name }} {{ $order->billing_last_name }}</p>
                <p><strong>Email:</strong> {{ $order->billing_email }}</p>
                <p><strong>Phone:</strong> {{ $order->billing_phone }}</p>
            </div>
        </div>

        <!-- Billing Address -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Billing Address</h3>
            <address class="text-sm not-italic text-gray-600">
                {{ $order->billing_address }}<br>
                {{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_zip }}<br>
                {{ $order->billing_country }}
            </address>
        </div>

        <!-- Shipping Address -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Shipping Address</h3>
            <address class="text-sm not-italic text-gray-600">
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
                {{ $order->shipping_country }}
            </address>
        </div>

        <!-- Order Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Update Status</h3>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                @csrf
                <select name="status" class="w-full px-4 py-2 border rounded-lg mb-3">
                    <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                    <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    Update Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
