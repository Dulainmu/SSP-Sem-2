@extends('layouts.admin')

@section('title', 'Customer Details - Admin Panel')
@section('page-title', 'Customer Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.customers.index') }}" class="text-indigo-600 hover:underline">
        <i class="fas fa-arrow-left mr-1"></i> Back to Customers
    </a>
</div>

<!-- Customer Info Card -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex items-start justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-indigo-600 text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $customer->name }}</h2>
                <p class="text-gray-600">{{ $customer->email }}</p>
                @if($customer->phone)
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="fas fa-phone mr-1"></i> {{ $customer->phone }}
                    </p>
                @endif
                @if($customer->address)
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="fas fa-map-marker-alt mr-1"></i> 
                        {{ $customer->address }}
                        @if($customer->city), {{ $customer->city }}@endif
                        @if($customer->state), {{ $customer->state }}@endif
                        @if($customer->postal_code) {{ $customer->postal_code }}@endif
                    </p>
                @endif
            </div>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500 mb-1">Member since</div>
            <div class="text-lg font-semibold">{{ $customer->created_at->format('M d, Y') }}</div>
            <span class="inline-block px-3 py-1 mt-2 text-xs rounded-full 
                {{ $customer->status == 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $customer->status }}
            </span>
            <form action="{{ route('admin.customers.toggleBlock', $customer) }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" 
                        onclick="return confirm('Are you sure you want to {{ $customer->status == 'Active' ? 'block' : 'unblock' }} this customer?')"
                        class="px-4 py-2 rounded-lg text-sm font-medium {{ $customer->status == 'Active' ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}">
                    <i class="fas fa-{{ $customer->status == 'Active' ? 'ban' : 'check-circle' }} mr-1"></i>
                    {{ $customer->status == 'Active' ? 'Block Customer' : 'Unblock Customer' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Statistics -->
    <div class="mt-6 grid grid-cols-4 gap-4">
        <div class="text-center p-4 bg-blue-50 rounded-lg">
            <div class="text-3xl font-bold text-blue-600">{{ $customer->orders->count() }}</div>
            <div class="text-sm text-gray-600 mt-1">Total Orders</div>
        </div>
        <div class="text-center p-4 bg-green-50 rounded-lg">
            <div class="text-3xl font-bold text-green-600">
                ${{ number_format($customer->orders->sum('total_amount'), 2) }}
            </div>
            <div class="text-sm text-gray-600 mt-1">Total Spent</div>
        </div>
        <div class="text-center p-4 bg-purple-50 rounded-lg">
            <div class="text-3xl font-bold text-purple-600">
                ${{ $customer->orders->count() > 0 ? number_format($customer->orders->sum('total_amount') / $customer->orders->count(), 2) : '0.00' }}
            </div>
            <div class="text-sm text-gray-600 mt-1">Avg. Order</div>
        </div>
        <div class="text-center p-4 bg-yellow-50 rounded-lg">
            <div class="text-3xl font-bold text-yellow-600">
                {{ $customer->orders->where('status', 'Pending')->count() }}
            </div>
            <div class="text-sm text-gray-600 mt-1">Pending Orders</div>
        </div>
    </div>
</div>

<!-- Orders List -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 bg-gray-50 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Order History</h3>
    </div>
    
    @if($customer->orders->isNotEmpty())
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($customer->orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        #{{ $order->order_number }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        <div>{{ $order->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-400">{{ $order->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $order->items->count() }} item{{ $order->items->count() != 1 ? 's' : '' }}
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                        ${{ number_format($order->total_amount, 2) }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $order->payment_method }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $order->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $order->status == 'Processing' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $order->status == 'Shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $order->status == 'Delivered' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $order->status == 'Cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('admin.orders.show', $order) }}" 
                           class="text-indigo-600 hover:text-indigo-900 font-medium">
                            <i class="fas fa-eye mr-1"></i> View
                        </a>
                    </td>
                </tr>
                
                <!-- Order Items Expandable -->
                <tr class="bg-gray-50">
                    <td colspan="7" class="px-6 py-4">
                        <div class="space-y-2">
                            <div class="text-xs font-semibold text-gray-500 uppercase mb-2">Order Items:</div>
                            @foreach($order->items as $item)
                            <div class="flex items-center justify-between bg-white p-3 rounded">
                                <div class="flex items-center space-x-3">
                                    @if($item->product)
                                        <img src="{{ asset($item->product->image_url) }}" 
                                             alt="{{ $item->product_name }}" 
                                             class="w-12 h-12 object-cover rounded">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-box text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                        <div class="text-xs text-gray-500">
                                            Qty: {{ $item->quantity }}
                                            @if(!$item->product)
                                                <span class="text-red-500 ml-2">(Product Deleted)</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-semibold text-gray-900">
                                        ${{ number_format($item->price, 2) }} × {{ $item->quantity }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        = ${{ number_format($item->price * $item->quantity, 2) }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="p-12 text-center">
            <i class="fas fa-shopping-cart text-gray-300 text-5xl mb-4"></i>
            <p class="text-xl text-gray-500">No orders yet</p>
        </div>
    @endif
</div>
@endsection
