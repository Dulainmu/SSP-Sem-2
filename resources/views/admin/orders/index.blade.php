@extends('layouts.admin')

@section('title', 'Orders - Admin Panel')
@section('page-title', 'Orders')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" placeholder="Search by order # or customer..." 
                   class="px-4 py-2 border rounded-lg" value="{{ request('search') }}">
            <select name="status" class="px-4 py-2 border rounded-lg">
                <option value="">All Status</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                <option value="Shipped" {{ request('status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-search mr-1"></i> Search
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">
                    <i class="fas fa-times mr-1"></i> Clear
                </a>
            @endif
        </form>
    </div>
    <div class="text-sm text-gray-600">
        Total: <span class="font-semibold">{{ $orders->total() }}</span> orders
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:underline">
                        #{{ $order->order_number }}
                    </a>
                </td>
                <td class="px-6 py-4 text-sm">
                    <div class="font-medium text-gray-900">{{ $order->user->name ?? 'Guest' }}</div>
                    <div class="text-gray-500">{{ $order->user->email ?? $order->billing_email }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    <div>{{ $order->created_at->format('M d, Y') }}</div>
                    <div class="text-xs text-gray-400">{{ $order->created_at->format('h:i A') }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $order->items->count() }} item{{ $order->items->count() != 1 ? 's' : '' }}
                </td>
                <td class="px-6 py-4 text-sm font-semibold text-gray-900">${{ number_format($order->total_amount, 2) }}</td>
                <td class="px-6 py-4 text-sm">
                    <div class="text-gray-900">{{ $order->payment_method }}</div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $order->payment_status == 'Paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $order->payment_status }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" 
                          onchange="if(confirm('Update order status?')) this.submit()">
                        @csrf
                        <select name="status" class="px-2 py-1 text-xs rounded-full border-0
                            {{ $order->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $order->status == 'Processing' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $order->status == 'Shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $order->status == 'Delivered' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $order->status == 'Cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                            <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </td>
                <td class="px-6 py-4 text-sm">
                    <a href="{{ route('admin.orders.show', $order) }}" 
                       class="text-indigo-600 hover:text-indigo-900 font-medium">
                        <i class="fas fa-eye mr-1"></i> View
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-12 text-center">
                    <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                    <p class="text-gray-500">No orders found</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $orders->appends(request()->query())->links() }}
</div>
@endsection
