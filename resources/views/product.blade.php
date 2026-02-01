@extends('layouts.app')

@section('title', $product->name . ' - Celario')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen py-12">
    <div class=" mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                <!-- Product Images -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-12 lg:p-16 flex items-center justify-center">
                    <div class="relative">
                        <img id="mainProductImage" 
                             src="{{ $product->image_url ? $product->image_url : 'https://via.placeholder.com/600' }}" 
                             alt="{{ $product->name }}" 
                             class="w-full max-w-md rounded-2xl shadow-lg hover:scale-105 transition-all duration-500 ease-in-out">
                        <div id="colorLabel" class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full shadow-lg hidden">
                            <span class="font-semibold text-gray-800 text-sm">Color: <span id="colorLabelText"></span></span>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-8 lg:p-12">
                    <h1 class="text-4xl font-bold mb-4 text-gray-900">{{ $product->name }}</h1>
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-6 h-6 {{ $i <= round($product->reviews_avg_rating ?? 0) ? 'fill-current' : 'fill-gray-300' }}" 
                                     viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="ml-3 text-gray-600 font-medium">({{ $product->reviews_count ?? 0 }} reviews)</span>
                    </div>

                    <div class="mb-8 pb-8 border-b">
                        <div class="flex items-baseline gap-3 mb-2">
                            <span id="productPrice" class="text-5xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</span>
                            @if($product->compare_price)
                                <span class="text-2xl text-gray-400 line-through">${{ number_format($product->compare_price, 2) }}</span>
                            @endif
                        </div>
                        @if($product->compare_price)
                            <span class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                                Save {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                            </span>
                        @endif
                    </div>

                    <p class="text-gray-700 mb-8 text-lg leading-relaxed">{{ $product->short_description }}</p>

                    <!-- Color Variants -->
                    @if($product->variants && $product->variants->count() > 0)
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-palette mr-2"></i>Select Color:
                                <span id="selectedColorName" class="ml-2 text-blue-600"></span>
                            </label>
                            <div class="flex flex-wrap gap-3" id="colorVariants">
                                @foreach($product->variants as $variant)
                                    <button 
                                        onclick="selectVariant({{ $variant->id }}, '{{ $variant->color_name }}', '{{ $variant->image_url }}', {{ $variant->stock_quantity }}, '{{ $variant->color_code }}')"
                                        class="variant-btn flex items-center gap-2 px-5 py-3 border-2 border-gray-300 rounded-xl hover:border-blue-500 transition-all duration-200 group hover:shadow-md"
                                        data-variant-id="{{ $variant->id }}"
                                        title="Select {{ $variant->color_name }}">
                                        @if($variant->color_code)
                                            <span class="w-8 h-8 rounded-full border-2 border-gray-300 group-hover:border-blue-500 shadow-sm" 
                                                  style="background-color: {{ $variant->color_code }}"></span>
                                        @endif
                                        <div class="text-left">
                                            <span class="font-semibold text-gray-700 group-hover:text-blue-600 block">{{ $variant->color_name }}</span>
                                            <span class="text-xs text-gray-500">{{ $variant->stock_quantity > 0 ? $variant->stock_quantity . ' available' : 'Out of stock' }}</span>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" id="selectedVariantId" value="">
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-info-circle"></i> Click a color to see its specific product image
                            </p>
                        </div>
                    @endif

                    <!-- Stock Status -->
                    <div class="mb-8">
                        <span id="stockStatus">
                            @if($product->stock_quantity > 0)
                                <span class="inline-flex items-center bg-green-100 text-green-700 px-4 py-2 rounded-full font-semibold">
                                    <i class="fas fa-check-circle mr-2"></i>In Stock (<span id="stockQuantity">{{ $product->stock_quantity }}</span> available)
                                </span>
                            @else
                                <span class="inline-flex items-center bg-red-100 text-red-700 px-4 py-2 rounded-full font-semibold">
                                    <i class="fas fa-times-circle mr-2"></i>Out of Stock
                                </span>
                            @endif
                        </span>
                    </div>

                    <!-- Add to Cart -->
                    @auth
                        @if(auth()->user()->user_role !== 'Admin')
                            <div class="flex gap-4 mb-8">
                                <input type="number" value="1" min="1" max="{{ $product->stock_quantity }}" 
                                       id="quantity" 
                                       class="w-24 border-2 border-gray-300 rounded-xl px-4 py-3 text-center text-lg font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                                <button onclick="addToCart({{ $product->id }})" 
                                        class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 rounded-xl font-bold text-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg {{ $product->stock_quantity <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                </button>
                                <button onclick="toggleWishlist({{ $product->id }}, this)" 
                                        class="border-2 border-red-500 text-red-500 px-6 py-4 rounded-xl hover:bg-red-50 transition-all duration-200 wishlist-btn transform hover:scale-105"
                                        data-product-id="{{ $product->id }}"
                                        title="Add to Wishlist">
                                    <i class="far fa-heart text-2xl"></i>
                                </button>
                            </div>
                        @else
                            <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-6 mb-8">
                                <p class="text-blue-800 font-semibold flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    You are viewing as Admin. Shopping features are disabled.
                                </p>
                            </div>
                        @endif
                    @else
                        <div class="flex gap-4 mb-8">
                            <input type="number" value="1" min="1" max="{{ $product->stock_quantity }}" 
                                   id="quantity" 
                                   class="w-24 border-2 border-gray-300 rounded-xl px-4 py-3 text-center text-lg font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                            <button onclick="addToCart({{ $product->id }})" 
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 rounded-xl font-bold text-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg {{ $product->stock_quantity <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                            </button>
                            <button onclick="toggleWishlist({{ $product->id }}, this)" 
                                    class="border-2 border-red-500 text-red-500 px-6 py-4 rounded-xl hover:bg-red-50 transition-all duration-200 wishlist-btn transform hover:scale-105"
                                    data-product-id="{{ $product->id }}"
                                    title="Add to Wishlist">
                                <i class="far fa-heart text-2xl"></i>
                            </button>
                        </div>
                    @endauth

                    <!-- Product Details -->
                    <div class="bg-gray-50 rounded-2xl p-6">
                        <h3 class="font-bold text-xl mb-4 text-gray-900">Product Details</h3>
                        <ul class="space-y-3 text-gray-700">
                            <li class="flex items-center">
                                <span class="font-semibold w-24">SKU:</span>
                                <span>{{ $product->sku }}</span>
                            </li>
                            <li class="flex items-center">
                                <span class="font-semibold w-24">Brand:</span>
                                <span>{{ $product->brand->name ?? 'N/A' }}</span>
                            </li>
                            <li class="flex items-center">
                                <span class="font-semibold w-24">Category:</span>
                                <span>{{ $product->category->name ?? 'N/A' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="px-8 lg:px-12 py-12 border-t">
                <h2 class="text-3xl font-bold mb-6 text-gray-900">Description</h2>
                <div class="prose max-w-none text-gray-700 text-lg leading-relaxed">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            <!-- Reviews -->
            <div class="px-8 lg:px-12 py-12 border-t bg-gray-50">
                <h2 class="text-3xl font-bold mb-8 text-gray-900">Customer Reviews</h2>
                <div id="reviews-container" class="space-y-6">
                    <!-- Reviews will be loaded via JavaScript -->
                </div>

                @auth
                <div class="mt-8 bg-white p-8 rounded-2xl shadow-lg">
                    <h3 class="font-bold text-xl mb-6 text-gray-900">Write a Review</h3>
                    <form onsubmit="submitReview(event, {{ $product->id }})">
                    <div class="mb-4">
                        <label class="block mb-2">Rating</label>
                        <select name="rating" required class="border rounded-lg px-3 py-2">
                            <option value="5">5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2">Review</label>
                        <textarea name="comment" required rows="4" 
                                  class="w-full border rounded-lg px-3 py-2"></textarea>
                    </div>
                    <button type="submit" 
                            class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                        Submit Review
                    </button>
                </form>
            </div>
            @endauth
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">You May Also Like</h2>
                <p class="text-gray-600">Check out these similar products</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-white border-2 border-gray-100 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden group">
                        <a href="{{ route('product', $relatedProduct->id) }}" class="block relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 group-hover:from-blue-50 group-hover:to-indigo-50 transition-all duration-300">
                            @if($relatedProduct->compare_price && $relatedProduct->compare_price > $relatedProduct->price)
                                <span class="absolute top-4 right-4 z-10 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                    -{{ round((($relatedProduct->compare_price - $relatedProduct->price) / $relatedProduct->compare_price) * 100) }}%
                                </span>
                            @endif
                            <img src="{{ $relatedProduct->image_url ? asset($relatedProduct->image_url) : 'https://via.placeholder.com/300' }}" 
                                 alt="{{ $relatedProduct->name }}" 
                                 class="w-full h-56 object-contain p-6 group-hover:scale-110 transition-transform duration-300">
                        </a>
                        <div class="p-5">
                            <a href="{{ route('product', $relatedProduct->id) }}" class="font-bold text-lg mb-2 text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2 block">
                                {{ $relatedProduct->name }}
                            </a>
                            <p class="text-gray-500 text-sm mb-3">{{ $relatedProduct->brand->name ?? '' }}</p>
                            <div class="flex items-center gap-2 mb-4">
                                <span class="text-blue-600 font-bold text-xl">${{ number_format($relatedProduct->price, 2) }}</span>
                                @if($relatedProduct->compare_price && $relatedProduct->compare_price > $relatedProduct->price)
                                    <span class="text-gray-400 text-sm line-through">${{ number_format($relatedProduct->compare_price, 2) }}</span>
                                @endif
                            </div>
                            @auth
                                @if(auth()->user()->user_role !== 'Admin')
                                    <div class="flex gap-2">
                                        <button onclick="event.stopPropagation(); addToCart({{ $relatedProduct->id }})" 
                                                class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2.5 rounded-xl hover:from-blue-700 hover:to-indigo-700 font-semibold text-sm transition-all transform hover:scale-105">
                                            <i class="fas fa-cart-plus mr-1"></i>Add
                                        </button>
                                        <button onclick="event.stopPropagation(); toggleWishlist({{ $relatedProduct->id }}, this)" 
                                                class="border-2 border-red-500 text-red-500 px-3 py-2.5 rounded-xl hover:bg-red-50 wishlist-btn transition-all transform hover:scale-105"
                                                data-product-id="{{ $relatedProduct->id }}"
                                                title="Add to Wishlist">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </div>
                                @endif
                            @else
                                <div class="flex gap-2">
                                    <button onclick="event.stopPropagation(); addToCart({{ $relatedProduct->id }})" 
                                            class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2.5 rounded-xl hover:from-blue-700 hover:to-indigo-700 font-semibold text-sm transition-all transform hover:scale-105">
                                        <i class="fas fa-cart-plus mr-1"></i>Add
                                    </button>
                                    <button onclick="event.stopPropagation(); toggleWishlist({{ $relatedProduct->id }}, this)" 
                                            class="border-2 border-red-500 text-red-500 px-3 py-2.5 rounded-xl hover:bg-red-50 wishlist-btn transition-all transform hover:scale-105"
                                            data-product-id="{{ $relatedProduct->id }}"
                                            title="Add to Wishlist">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Debug: Log when script loads
console.log('Product page scripts loaded');
console.log('API_URL:', typeof API_URL !== 'undefined' ? API_URL : 'UNDEFINED');
console.log('authToken:', typeof authToken !== 'undefined' ? (authToken ? 'EXISTS' : 'EMPTY') : 'UNDEFINED');

// Load reviews
async function loadReviews(productId) {
    try {
        const response = await fetch(`${API_URL}/reviews/product/${productId}`);
        const data = await response.json();
        
        const container = document.getElementById('reviews-container');
        if (data.success && data.data.length > 0) {
            container.innerHTML = data.data.map(review => `
                <div class="border-b pb-4">
                    <div class="flex items-center mb-2">
                        <div class="font-semibold">${review.user.name}</div>
                        <div class="ml-4 flex text-yellow-400">
                            ${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}
                        </div>
                    </div>
                    <p class="text-gray-700">${review.comment}</p>
                    <p class="text-sm text-gray-500 mt-2">${new Date(review.created_at).toLocaleDateString()}</p>
                </div>
            `).join('');
        } else {
            container.innerHTML = '<p class="text-gray-500">No reviews yet. Be the first to review!</p>';
        }
    } catch (error) {
        console.error('Error loading reviews:', error);
    }
}

// Add to cart
async function addToCart(productId) {
    console.log('🛒 Add to cart clicked - Product ID:', productId);
    
    const quantity = document.getElementById('quantity').value;
    const selectedVariantId = document.getElementById('selectedVariantId')?.value;
    
    console.log('Quantity:', quantity, 'Variant ID:', selectedVariantId);
    
    // If product has variants but none selected, show warning
    const variantsContainer = document.getElementById('colorVariants');
    if (variantsContainer && variantsContainer.children.length > 0 && !selectedVariantId) {
        alert('Please select a color variant first!');
        return;
    }
    
    try {
        const requestBody = { 
            product_id: productId, 
            quantity: parseInt(quantity) 
        };
        
        // Include variant ID if selected
        if (selectedVariantId) {
            requestBody.variant_id = parseInt(selectedVariantId);
        }
        
        console.log('Making API request to:', `${API_URL}/cart`);
        console.log('Request body:', requestBody);
        console.log('Auth token present:', !!authToken);
        
        const response = await fetch(`${API_URL}/cart`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                ...(authToken ? { 'Authorization': `Bearer ${authToken}` } : {})
            },
            body: JSON.stringify(requestBody)
        });
        
        console.log('Response status:', response.status);
        const data = await response.json();
        console.log('Response data:', data);
        
        if (data.success) {
            const colorName = selectedVariantId ? document.getElementById('selectedColorName')?.textContent : '';
            alert(`Product added to cart! ${colorName}`);
            if (typeof fetchCartCount === 'function') {
                fetchCartCount();
            }
        } else {
            alert(data.message || 'Failed to add to cart');
        }
    } catch (error) {
        console.error('❌ Error adding to cart:', error);
        alert('Failed to add to cart. Check console for details.');
    }
}

// Load wishlist state on page load
async function loadWishlistState() {
    if (!authToken) return;
    
    try {
        const response = await fetch(`${API_URL}/wishlist`, {
            headers: {
                'Authorization': `Bearer ${authToken}`
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            const wishlistProductIds = data.wishlist.map(item => item.product_id);
            
            // Update wishlist buttons
            document.querySelectorAll('.wishlist-btn').forEach(btn => {
                const productId = parseInt(btn.dataset.productId);
                const icon = btn.querySelector('i');
                
                if (wishlistProductIds.includes(productId)) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                }
            });
        }
    } catch (error) {
        console.error('Error loading wishlist:', error);
    }
}

// Toggle wishlist
async function toggleWishlist(productId, button) {
    console.log('❤️ Wishlist toggle clicked - Product ID:', productId);
    console.log('Auth token present:', !!authToken);
    
    if (!authToken) {
        console.log('No auth token, redirecting to login');
        alert('Please login to add items to wishlist');
        window.location.href = '/login';
        return;
    }
    
    const icon = button.querySelector('i');
    const isInWishlist = icon.classList.contains('fas');
    
    console.log('Current wishlist state:', isInWishlist ? 'In wishlist' : 'Not in wishlist');
    
    try {
        let response;
        
        if (isInWishlist) {
            console.log('Removing from wishlist...');
            // Remove from wishlist
            response = await fetch(`${API_URL}/wishlist/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${authToken}`
                }
            });
        } else {
            console.log('Adding to wishlist...');
            // Add to wishlist
            response = await fetch(`${API_URL}/wishlist`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                },
                body: JSON.stringify({ product_id: productId })
            });
        }
        
        console.log('Response status:', response.status);
        const data = await response.json();
        console.log('Response data:', data);
        
        if (data.success) {
            // Toggle icon
            if (isInWishlist) {
                icon.classList.remove('fas');
                icon.classList.add('far');
                alert('Removed from wishlist');
            } else {
                icon.classList.remove('far');
                icon.classList.add('fas');
                alert('Added to wishlist!');
            }
        } else {
            alert(data.message || 'Failed to update wishlist');
        }
    } catch (error) {
        console.error('❌ Error:', error);
        alert('Failed to update wishlist. Check console for details.');
    }
}

// Submit review
async function submitReview(event, productId) {
    event.preventDefault();
    
    if (!authToken) {
        alert('Please login to submit a review');
        window.location.href = '/login';
        return;
    }
    
    const form = event.target;
    const formData = new FormData(form);
    
    try {
        const response = await fetch(`${API_URL}/reviews`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify({
                product_id: productId,
                rating: parseInt(formData.get('rating')),
                comment: formData.get('comment')
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Review submitted successfully!');
            form.reset();
            loadReviews(productId);
        } else {
            alert(data.message || 'Failed to submit review');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to submit review');
    }
}

// Load wishlist state on page load
async function loadWishlistState() {
    if (!authToken) return;
    
    try {
        const response = await fetch(`${API_URL}/wishlist`, {
            headers: {
                'Authorization': `Bearer ${authToken}`
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            const wishlistProductIds = data.data.map(item => item.product_id);
            
            // Update wishlist buttons
            document.querySelectorAll('.wishlist-btn').forEach(btn => {
                const productId = parseInt(btn.dataset.productId);
                const icon = btn.querySelector('i');
                
                if (wishlistProductIds.includes(productId)) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                }
            });
        }
    } catch (error) {
        console.error('Error loading wishlist:', error);
    }
}

// Load reviews on page load
document.addEventListener('DOMContentLoaded', () => {
    loadReviews({{ $product->id }});
    loadWishlistState();
});

// Color variant selection
function selectVariant(variantId, colorName, imageUrl, stockQuantity, colorCode) {
    // Update selected variant
    document.getElementById('selectedVariantId').value = variantId;
    
    // Update selected color name display
    const selectedColorName = document.getElementById('selectedColorName');
    if (selectedColorName) {
        selectedColorName.textContent = `(${colorName})`;
    }
    
    // Update color label on image
    const colorLabel = document.getElementById('colorLabel');
    const colorLabelText = document.getElementById('colorLabelText');
    if (colorLabel && colorLabelText) {
        colorLabelText.textContent = colorName;
        colorLabel.classList.remove('hidden');
    }
    
    // Update image if variant has one with smooth transition
    const mainImage = document.getElementById('mainProductImage');
    if (imageUrl && imageUrl !== 'null' && imageUrl !== '') {
        // Add fade effect
        mainImage.style.opacity = '0.5';
        setTimeout(() => {
            mainImage.src = imageUrl;
            mainImage.style.opacity = '1';
        }, 200);
        
        console.log('✓ Image updated to:', imageUrl);
    } else {
        // Fall back to main product image
        mainImage.style.opacity = '0.5';
        setTimeout(() => {
            mainImage.src = '{{ $product->image_url ? $product->image_url : "https://via.placeholder.com/600" }}';
            mainImage.style.opacity = '1';
        }, 200);
        
        console.log('⚠ No variant image found, using main product image');
    }
    
    // Update stock quantity
    document.getElementById('stockQuantity').textContent = stockQuantity;
    
    // Update quantity input max value
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        quantityInput.max = stockQuantity;
        if (quantityInput.value > stockQuantity) {
            quantityInput.value = stockQuantity > 0 ? 1 : 0;
        }
    }
    
    // Update stock status
    const stockStatusContainer = document.getElementById('stockStatus');
    if (stockQuantity > 0) {
        stockStatusContainer.innerHTML = `
            <span class="inline-flex items-center bg-green-100 text-green-700 px-4 py-2 rounded-full font-semibold">
                <i class="fas fa-check-circle mr-2"></i>In Stock (<span id="stockQuantity">${stockQuantity}</span> available)
            </span>
        `;
    } else {
        stockStatusContainer.innerHTML = `
            <span class="inline-flex items-center bg-red-100 text-red-700 px-4 py-2 rounded-full font-semibold">
                <i class="fas fa-times-circle mr-2"></i>Out of Stock
            </span>
        `;
    }
    
    // Enable/disable add to cart button based on stock
    const addToCartBtn = document.querySelector('button[onclick^="addToCart"]');
    if (addToCartBtn) {
        if (stockQuantity <= 0) {
            addToCartBtn.disabled = true;
            addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            addToCartBtn.disabled = false;
            addToCartBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
    
    // Update button styles - highlight selected with animation
    document.querySelectorAll('.variant-btn').forEach(btn => {
        if (btn.dataset.variantId == variantId) {
            btn.classList.remove('border-gray-300');
            btn.classList.add('border-blue-500', 'bg-blue-50', 'ring-2', 'ring-blue-300', 'scale-105');
        } else {
            btn.classList.add('border-gray-300');
            btn.classList.remove('border-blue-500', 'bg-blue-50', 'ring-2', 'ring-blue-300', 'scale-105');
        }
    });
    
    console.log('✓ Selected variant:', colorName, '| Stock:', stockQuantity, '| ID:', variantId);
}
</script>
@endpush
@endsection
