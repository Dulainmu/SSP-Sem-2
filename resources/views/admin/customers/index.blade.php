@extends('layouts.admin')

@section('title', 'Customers - Admin Panel')
@section('page-title', 'Customers')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" placeholder="Search by name or email..." 
                   class="px-4 py-2 border rounded-lg w-80" value="{{ request('search') }}">
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-search mr-1"></i> Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.customers.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">
                    <i class="fas fa-times mr-1"></i> Clear
                </a>
            @endif
        </form>
    </div>
    <div class="text-sm text-gray-600">
        Total: <span class="font-semibold">{{ $customers->total() }}</span> customers
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Member Since</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orders</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Spent</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($customers as $customer)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-indigo-600"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                            <div class="text-xs text-gray-500">ID: {{ $customer->id }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm">
                    <div class="text-gray-900">{{ $customer->email }}</div>
                    @if($customer->phone)
                        <div class="text-gray-500 text-xs mt-1">
                            <i class="fas fa-phone mr-1"></i> {{ $customer->phone }}
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $customer->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4">
                    <div class="text-center">
                        <div class="text-lg font-bold text-blue-600">{{ $customer->orders_count }}</div>
                        <div class="text-xs text-gray-500">orders</div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm">
                    <div class="font-semibold text-gray-900">
                        ${{ number_format($customer->orders->sum('total_amount'), 2) }}
                    </div>
                    @if($customer->orders_count > 0)
                        <div class="text-xs text-gray-500">
                            Avg: ${{ number_format($customer->orders->sum('total_amount') / $customer->orders_count, 2) }}
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $customer->status == 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $customer->status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm">
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.customers.show', $customer) }}" 
                           class="text-indigo-600 hover:text-indigo-900 font-medium">
                            View
                        </a>
                        <form action="{{ route('admin.customers.toggleBlock', $customer) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to {{ $customer->status == 'Active' ? 'block' : 'unblock' }} this customer?')"
                                    class="text-{{ $customer->status == 'Active' ? 'red' : 'green' }}-600 hover:text-{{ $customer->status == 'Active' ? 'red' : 'green' }}-900 font-medium">
                                {{ $customer->status == 'Active' ? 'Block' : 'Unblock' }}
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center">
                    <i class="fas fa-users text-gray-300 text-5xl mb-4"></i>
                    <p class="text-xl text-gray-500">No customers found</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $customers->appends(request()->query())->links() }}
</div>
@endsection
