@extends('layouts.admin')

@section('title', 'Add Product - Admin Panel')
@section('page-title', 'Add New Product')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Product Name -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                <input type="text" name="name" required 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" 
                       value="{{ old('name') }}">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- SKU -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">SKU *</label>
                <input type="text" name="sku" required 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" 
                       value="{{ old('sku') }}">
                @error('sku')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select name="category_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Brand -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                <select name="brand_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
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
                       value="{{ old('price') }}">
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Compare Price -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Compare Price</label>
                <input type="number" name="compare_price" step="0.01" 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" 
                       value="{{ old('compare_price') }}">
            </div>

            <!-- Stock Quantity -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity *</label>
                <input type="number" name="stock_quantity" required 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                       value="{{ old('stock_quantity', 0) }}">
                @error('stock_quantity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                <input type="file" name="image" accept="image/*" 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Short Description -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                <textarea name="short_description" rows="2" 
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('short_description') }}</textarea>
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4" 
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
            </div>

            <!-- Color Variants Section -->
            <div class="md:col-span-2 border-t pt-6 mt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Color Variants (Optional)</h3>
                    <button type="button" onclick="addVariant()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">
                        + Add Color Variant
                    </button>
                </div>
                
                <div id="variants-container" class="space-y-4">
                    <!-- Variants will be added here dynamically -->
                </div>
            </div>

            <!-- Checkboxes -->
            <div class="md:col-span-2 space-y-2">
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="mr-2">
                    <span class="text-sm text-gray-700">Featured Product</span>
                </label>
                <label class="flex items-center">
                    <span class="text-sm text-gray-700">Status</span>
                    <select name="status" class="ml-2 px-3 py-1 border rounded">
                        <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Out of Stock" {{ old('status') == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </label>
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Create Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
let variantIndex = 0;

// Predefined color options
const colorOptions = [
    { name: 'Black', code: '#000000' },
    { name: 'White', code: '#FFFFFF' },
    { name: 'Red', code: '#FF0000' },
    { name: 'Blue', code: '#0000FF' },
    { name: 'Navy Blue', code: '#000080' },
    { name: 'Sky Blue', code: '#87CEEB' },
    { name: 'Green', code: '#008000' },
    { name: 'Yellow', code: '#FFFF00' },
    { name: 'Orange', code: '#FFA500' },
    { name: 'Pink', code: '#FFC0CB' },
    { name: 'Purple', code: '#800080' },
    { name: 'Brown', code: '#8B4513' },
    { name: 'Gray', code: '#808080' },
    { name: 'Beige', code: '#F5F5DC' },
    { name: 'Maroon', code: '#800000' },
    { name: 'Teal', code: '#008080' },
    { name: 'Gold', code: '#FFD700' },
    { name: 'Silver', code: '#C0C0C0' },
];

function addVariant() {
    const container = document.getElementById('variants-container');
    
    // Create color options HTML
    const colorOptionsHtml = colorOptions.map(color => 
        `<option value="${color.name}" data-color="${color.code}">${color.name}</option>`
    ).join('');
    
    const variantHtml = `
        <div class="variant-item border-2 border-indigo-200 rounded-lg p-6 bg-gradient-to-r from-indigo-50 to-blue-50" data-index="${variantIndex}">
            <div class="flex justify-between items-start mb-4">
                <h4 class="font-semibold text-indigo-800 text-lg flex items-center">
                    <span class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center mr-2 text-sm">${variantIndex + 1}</span>
                    Color Variant #${variantIndex + 1}
                </h4>
                <button type="button" onclick="removeVariant(this)" class="text-red-600 hover:text-red-800 text-sm font-medium px-3 py-1 border border-red-300 rounded hover:bg-red-50 transition">
                    ✕ Remove
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Color Selection -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-palette mr-1"></i> Select Color *
                    </label>
                    <div class="flex gap-3">
                        <select 
                            name="variants[${variantIndex}][color_name]" 
                            required 
                            onchange="updateColorPreview(this, ${variantIndex})"
                            class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-medium">
                            <option value="">Choose a color...</option>
                            ${colorOptionsHtml}
                            <option value="custom">Custom Color</option>
                        </select>
                        <div id="color-preview-${variantIndex}" class="w-16 h-10 border-2 border-gray-300 rounded-lg shadow-inner bg-white flex items-center justify-center text-xs text-gray-400">
                            Preview
                        </div>
                    </div>
                </div>

                <!-- Custom Color Name (Hidden by default) -->
                <div id="custom-color-${variantIndex}" class="hidden md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Custom Color Name *</label>
                    <input type="text" 
                           id="custom-color-name-${variantIndex}"
                           placeholder="e.g., Coral Pink, Ocean Blue"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <!-- Color Code Picker -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-eyedropper mr-1"></i> Color Code (Hex)
                    </label>
                    <div class="flex gap-2">
                        <input type="color" 
                               name="variants[${variantIndex}][color_code]" 
                               id="color-code-${variantIndex}"
                               value="#000000"
                               onchange="updateColorPreview(null, ${variantIndex})"
                               class="w-16 h-10 border-2 border-gray-300 rounded-lg cursor-pointer">
                        <input type="text" 
                               id="color-hex-${variantIndex}"
                               value="#000000"
                               readonly
                               class="flex-1 px-4 py-2 border rounded-lg bg-gray-50 font-mono text-sm">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Click to pick exact color shade</p>
                </div>
                
                <!-- Stock Quantity -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-boxes mr-1"></i> Stock Quantity
                    </label>
                    <input type="number" 
                           name="variants[${variantIndex}][stock_quantity]" 
                           value="0" 
                           min="0"
                           class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">Available units for this color</p>
                </div>
                
                <!-- Variant Image Upload -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-image mr-1"></i> Product Image for This Color *
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 bg-white hover:border-indigo-400 transition">
                        <input type="file" 
                               name="variants[${variantIndex}][image]" 
                               id="variant-image-${variantIndex}"
                               accept="image/*" 
                               onchange="previewImage(this, ${variantIndex})"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle"></i> Upload a photo showing this specific color variant (Max 10MB)
                        </p>
                    </div>
                    <!-- Image Preview -->
                    <div id="image-preview-${variantIndex}" class="hidden mt-3">
                        <img src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border-2 border-indigo-200 shadow-md">
                        <p class="text-xs text-green-600 mt-1"><i class="fas fa-check-circle"></i> Image ready to upload</p>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', variantHtml);
    variantIndex++;
}

function updateColorPreview(selectElement, index) {
    const preview = document.getElementById(`color-preview-${index}`);
    const colorCode = document.getElementById(`color-code-${index}`);
    const colorHex = document.getElementById(`color-hex-${index}`);
    const customColorDiv = document.getElementById(`custom-color-${index}`);
    const customColorInput = document.getElementById(`custom-color-name-${index}`);
    
    if (selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const colorValue = selectedOption.getAttribute('data-color');
        
        if (selectElement.value === 'custom') {
            // Show custom color input
            customColorDiv.classList.remove('hidden');
            customColorInput.required = true;
        } else {
            // Hide custom color input
            customColorDiv.classList.add('hidden');
            customColorInput.required = false;
            customColorInput.value = '';
        }
        
        if (colorValue) {
            preview.style.backgroundColor = colorValue;
            preview.textContent = '';
            colorCode.value = colorValue;
            colorHex.value = colorValue;
        }
    } else {
        // Update from color picker
        const pickerValue = colorCode.value;
        preview.style.backgroundColor = pickerValue;
        preview.textContent = '';
        colorHex.value = pickerValue;
    }
}

function previewImage(input, index) {
    const previewDiv = document.getElementById(`image-preview-${index}`);
    const previewImg = previewDiv.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewDiv.classList.remove('hidden');
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeVariant(button) {
    if (confirm('Remove this color variant?')) {
        button.closest('.variant-item').remove();
    }
}

// Add one variant by default when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Optionally add first variant automatically
    // addVariant();
});

// Update color name field based on custom input
document.addEventListener('input', function(e) {
    if (e.target.id.startsWith('custom-color-name-')) {
        const index = e.target.id.split('-').pop();
        const select = document.querySelector(`select[name="variants[${index}][color_name]"]`);
        if (select && select.value === 'custom') {
            // Update the hidden input or form data with custom color
            select.setAttribute('data-custom-value', e.target.value);
        }
    }
});

// Before form submission, update custom color names
document.querySelector('form').addEventListener('submit', function(e) {
    const customColorInputs = document.querySelectorAll('[id^="custom-color-name-"]');
    customColorInputs.forEach(input => {
        if (input.value) {
            const index = input.id.split('-').pop();
            const select = document.querySelector(`select[name="variants[${index}][color_name]"]`);
            if (select && select.value === 'custom') {
                // Create a hidden input with the custom color name
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `variants[${index}][color_name]`;
                hiddenInput.value = input.value;
                this.appendChild(hiddenInput);
                select.removeAttribute('name'); // Remove name from select to avoid duplicate
            }
        }
    });
});
</script>

@endsection
