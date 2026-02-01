@extends('layouts.admin')

@section('title', 'Edit Product - Admin Panel')
@section('page-title', 'Edit Product')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Product Name -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                <input type="text" name="name" required 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" 
                       value="{{ old('name', $product->name) }}">
            </div>

            <!-- SKU -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">SKU *</label>
                <input type="text" name="sku" required 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" 
                       value="{{ old('sku', $product->sku) }}">
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select name="category_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Brand -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                <select name="brand_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Price -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                <input type="number" name="price" step="0.01" required 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" 
                       value="{{ old('price', $product->price) }}">
            </div>

            <!-- Compare Price -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Compare Price</label>
                <input type="number" name="compare_price" step="0.01" 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" 
                       value="{{ old('compare_price', $product->compare_price) }}">
            </div>

            <!-- Stock Quantity -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity *</label>
                <input type="number" name="stock_quantity" required 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                       value="{{ old('stock_quantity', $product->stock_quantity) }}>
            </div>

            <!-- Current Image -->
            @if($product->image_url)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded">
            </div>
            @endif

            <!-- New Image -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Change Image</label>
                <input type="file" name="image" accept="image/*" 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Short Description -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                <textarea name="short_description" rows="2" 
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('short_description', $product->short_description) }}</textarea>
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4" 
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Checkboxes -->
            <div class="md:col-span-2 space-y-2">
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="mr-2">
                    <span class="text-sm text-gray-700">Featured Product</span>
                </label>
                <label class="flex items-center">
                    <span class="text-sm text-gray-700">Status</span>
                    <select name="status" class="ml-2 px-3 py-1 border rounded">
                        <option value="Active" {{ old('status', $product->status) == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', $product->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="Draft" {{ old('status', $product->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Out of Stock" {{ old('status', $product->status) == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                    <span class="text-sm text-gray-700">Active</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Update Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
