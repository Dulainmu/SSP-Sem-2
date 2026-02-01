<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cellario - E-Commerce')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out forwards;
        }
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-white" style="font-family: 'Inter', sans-serif;">
    <!-- Navigation -->
    <header class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg sticky top-0 z-50" x-data="{ open: false, cartCount: 0 }" x-init="fetchCartCount()">
        <div class="container mx-auto flex items-center justify-between py-4 px-6">
            <div class="text-3xl font-bold italic">
                <a href="{{ route('home') }}" class="hover:text-blue-200 transition-colors">Cellario</a>
            </div>
            <nav class="hidden md:block">
                <ul class="flex space-x-8 font-medium text-lg">
                    <li><a href="{{ route('home') }}" class="hover:text-blue-200 transition-colors">Home</a></li>
                    <li><a href="{{ route('shop') }}" class="hover:text-blue-200 transition-colors">Products</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-blue-200 transition-colors">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-blue-200 transition-colors">Contact</a></li>
                </ul>
            </nav>
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="hover:text-blue-200 px-4 py-2 rounded-lg border-2 border-white font-semibold transition-all hover:bg-white/10" title="Login">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="hover:bg-blue-700 bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold transition-all hover:scale-105" title="Sign Up">
                        Sign Up
                    </a>
                @else
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen" class="flex items-center space-x-2 hover:text-blue-200 bg-white/10 px-4 py-2 rounded-lg transition-all hover:bg-white/20">
                            <i class="fas fa-user"></i>
                            <span class="hidden md:inline font-medium">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false" 
                             class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl py-2 z-50 border border-gray-100">
                            @if(auth()->user()->user_role === 'Admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-5 py-3 text-sm text-gray-700 hover:bg-blue-50 transition-colors">
                                    <i class="fas fa-tachometer-alt mr-2 text-blue-600"></i>Admin Dashboard
                                </a>
                            @else
                                <a href="{{ route('profile') }}" class="block px-5 py-3 text-sm text-gray-700 hover:bg-blue-50 transition-colors">
                                    <i class="fas fa-user-edit mr-2 text-blue-600"></i>Edit Profile
                                </a>
                                <a href="{{ route('orders') }}" class="block px-5 py-3 text-sm text-gray-700 hover:bg-blue-50 transition-colors">
                                    <i class="fas fa-shopping-bag mr-2 text-blue-600"></i>My Orders
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="m-0" onsubmit="sessionStorage.removeItem('authToken')">
                                @csrf
                                <button type="submit" class="block w-full text-left px-5 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors border-t">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    @if(auth()->user()->user_role !== 'Admin')
                        <a href="{{ route('wishlist') }}" class="hover:text-blue-200 relative bg-white/10 p-3 rounded-lg hover:bg-white/20 transition-all" title="Wishlist">
                            <i class="fas fa-heart text-xl"></i>
                        </a>
                    @endif
                @endguest
                
                @if(!auth()->check() || auth()->user()->user_role !== 'Admin')
                    <a href="{{ route('cart') }}" class="hover:text-blue-200 relative bg-white/10 p-3 rounded-lg hover:bg-white/20 transition-all" title="View Cart">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span x-show="cartCount > 0" x-text="cartCount" 
                              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full min-w-[1.5rem] text-center"></span>
                    </a>
                @endif
            </div>
        </div>
    </header>

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Content -->
    <main>
        @if (isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-800 to-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid md:grid-cols-5 gap-8">
                <div class="flex flex-col items-start">
                    <div class="text-3xl font-bold italic mb-4 text-blue-400">Cellario</div>
                    <p class="text-gray-400 text-sm leading-relaxed">Your trusted electronics store for the latest gadgets and accessories.</p>
                    <div class="flex space-x-4 mt-6">
                        <a href="https://www.facebook.com/" class="bg-white/10 hover:bg-blue-600 w-10 h-10 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://www.twitter.com/" class="bg-white/10 hover:bg-blue-400 w-10 h-10 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.instagram.com/" class="bg-white/10 hover:bg-pink-600 w-10 h-10 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-lg text-blue-400">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Home
                        </a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>About Us
                        </a></li>
                        <li><a href="{{ route('shop') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Products
                        </a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Contact Us
                        </a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-lg text-blue-400">Categories</h4>
                    <ul class="space-y-2">
                        @foreach($categories ?? [] as $category)
                            <li><a href="{{ route('shop', ['category' => $category->id]) }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2"></i>{{ $category->name }}
                            </a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-lg text-blue-400">Account</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Login
                        </a></li>
                        <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Register
                        </a></li>
                        <li><a href="{{ route('cart') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>My Cart
                        </a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-lg text-blue-400">Contact Info</h4>
                    <ul class="space-y-3 text-gray-400 text-sm">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mr-3 mt-1 text-blue-400"></i>
                            <span>123 Tech Avenue, Colombo, Sri Lanka</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-blue-400"></i>
                            <a href="mailto:support@cellario.com" class="hover:text-white transition-colors">support@cellario.com</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3 text-blue-400"></i>
                            <a href="tel:+94112223344" class="hover:text-white transition-colors">+94 112 223344</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-700">
            <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">© 2025 Cellario. All rights reserved.</p>
                <div class="flex space-x-6 text-sm text-gray-400 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition-colors">Terms & Conditions</a>
                    <a href="#" class="hover:text-white transition-colors">Privacy Notice</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // API Base URL
        const API_URL = '/api';
        
        @auth
        // Store token in sessionStorage to avoid creating new tokens on each page load
        let authToken = sessionStorage.getItem('authToken');
        if (!authToken) {
            authToken = '{{ auth()->user()->createToken("web-token")->plainTextToken }}';
            sessionStorage.setItem('authToken', authToken);
        }
        @else
        let authToken = '';
        @endauth

        // Fetch cart count
        async function fetchCartCount() {
            if (!authToken) return;
            
            try {
                const response = await fetch(`${API_URL}/cart/count`, {
                    headers: { 'Authorization': `Bearer ${authToken}` }
                });
                const data = await response.json();
                if (data.success) {
                    Alpine.store('cart', { count: data.count });
                }
            } catch (error) {
                console.error('Error fetching cart count:', error);
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
