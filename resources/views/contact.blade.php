@extends('layouts.app')

@section('content')
<!-- Map Section -->
<section class="w-full my-10 px-0">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.7656129915895!2d79.85865397448282!3d6.918600618446974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2596d3cb8fe07%3A0x2b0ae2edd563a661!2sAsia%20Pacific%20Institute%20of%20Information%20Technology%20(APIIT)!5e0!3m2!1sen!2slk!4v1757850132401!5m2!1sen!2slk" 
        class="w-full min-h-[350px] md:min-h-[450px] object-cover rounded-lg shadow border-0">
    </iframe>
</section>

<!-- Contact Form & Details -->
<section class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 py-12 px-6">
    <!-- Left: Form -->
    <div>
        <h2 class="text-3xl font-bold mb-4">Get in Touch</h2>
        <p class="text-gray-600 mb-6">
            Have a question or need help? Fill out the form and our team will get back to you soon!
        </p>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-700">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-700">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('contact.submit') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-700">Name *</label>
                    <input type="text" name="name" placeholder="Your Name" required
                           value="{{ old('name') }}"
                           class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm text-gray-700">Email *</label>
                    <input type="email" name="email" placeholder="Your Email" required
                           value="{{ old('email') }}"
                           class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label class="text-sm text-gray-700">Subject *</label>
                <input type="text" name="subject" placeholder="Subject" required
                       value="{{ old('subject') }}"
                       class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('subject') border-red-500 @enderror">
                @error('subject')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="text-sm text-gray-700">Message *</label>
                <textarea name="message" placeholder="Type your message..." rows="4" required
                          class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors">
                <i class="fas fa-paper-plane mr-2"></i>Send Message
            </button>
        </form>
    </div>

    <!-- Right: Contact Details -->
    <div>
        <h2 class="text-3xl font-bold mb-4">Contact Details</h2>
        <p class="text-gray-600 mb-6">
            Reach out to us for any questions about our gadgets, your order, or partnership opportunities.
        </p>
        <div class="space-y-4">
            <div>
                <h3 class="font-semibold text-lg">Address</h3>
                <p class="text-gray-600">123 Tech Avenue, Colombo, Sri Lanka</p>
            </div>
            <div>
                <h3 class="font-semibold text-lg">Email</h3>
                <p class="text-gray-600">
                    <a href="mailto:support@cellario.com" class="hover:underline">support@cellario.com</a>
                </p>
            </div>
            <div>
                <h3 class="font-semibold text-lg">Phone</h3>
                <p class="text-gray-600">
                    <a href="tel:+94112223344" class="hover:underline">+94 112 223344</a>
                </p>
            </div>
            
            <div>
                <h3 class="font-semibold text-lg">Follow Us</h3>
                <div class="flex space-x-4 mt-2">
                    <a href="https://www.facebook.com/" target="_blank" title="Facebook" class="hover:text-blue-600">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <path d="M22.675 0h-21.35C.595 0 0 .592 0 1.326v21.348C0 23.406.595 24 1.325 24h11.495v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.797.143v3.24l-1.918.001c-1.504 0-1.797.715-1.797 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.406 24 24 23.406 24 22.674V1.326C24 .592 23.406 0 22.675 0"/>
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/" target="_blank" title="Instagram" class="hover:text-pink-500">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.974.974 1.246 2.241 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.974.974-2.241 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.974-.974-1.246-2.241-1.308-3.608C2.175 15.647 2.163 15.267 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608C4.515 2.497 5.782 2.225 7.148 2.163 8.414 2.105 8.794 2.163 12 2.163zm0-2.163C8.741 0 8.332.012 7.052.07 5.771.127 4.659.396 3.678 1.378 2.696 2.36 2.427 3.472 2.37 4.753.012 8.332 0 8.741 0 12c0 3.259.012 3.668.07 4.948.057 1.281.326 2.393 1.308 3.375.982.982 2.094 1.251 3.375 1.308C8.332 23.988 8.741 24 12 24s3.668-.012 4.948-.07c1.281-.057 2.393-.326 3.375-1.308.982-.982 1.251-2.094 1.308-3.375.058-1.28.07-1.689.07-4.948s-.012-3.668-.07-4.948c-.057-1.281-.326-2.393-1.308-3.375-.982-.982-2.094-1.251-3.375-1.308C15.668.012 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-7.998 3.999 3.999 0 0 1 0 7.998zm6.406-11.845a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Offices -->
<section class="max-w-7xl mx-auto py-12 px-6">
    <h2 class="text-3xl font-bold mb-6">Our Offices</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-lg mb-2">Colombo HQ</h3>
            <p class="text-gray-600 mb-1">123 Tech Avenue, Colombo, Sri Lanka</p>
            <p class="text-gray-600 mb-1">📧 <a href="mailto:colombo@cellario.com" class="hover:underline">colombo@cellario.com</a></p>
            <p class="text-gray-600">📞 +94 112 223344</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-lg mb-2">Kandy Branch</h3>
            <p class="text-gray-600 mb-1">456 Gadget Street, Kandy, Sri Lanka</p>
            <p class="text-gray-600 mb-1">📧 <a href="mailto:kandy@cellario.com" class="hover:underline">kandy@cellario.com</a></p>
            <p class="text-gray-600">📞 +94 812 334455</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-lg mb-2">Galle Branch</h3>
            <p class="text-gray-600 mb-1">789 Device Road, Galle, Sri Lanka</p>
            <p class="text-gray-600 mb-1">📧 <a href="mailto:galle@cellario.com" class="hover:underline">galle@cellario.com</a></p>
            <p class="text-gray-600">📞 +94 912 445566</p>
        </div>
    </div>
</section>
@endsection
