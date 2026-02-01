@extends('layouts.app')

@section('content')
<!-- About Us Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 grid lg:grid-cols-2 gap-10 items-start">
        <div>
            <p class="text-sm text-gray-500 mb-2">Home / About Us</p>
            <h2 class="text-3xl font-bold mb-4">About Us</h2>
            <h3 class="text-xl font-semibold mb-6">
                We Value Our Clients And Want Them To Have A Nice Experience
            </h3>
            <p class="text-gray-600 mb-3">
                Welcome to <strong>Cellario</strong>, your one-stop destination for the latest and most reliable tech gadgets.
                We believe technology should make life easier, smarter, and more exciting — and that's exactly what we deliver.
            </p>
            <p class="text-gray-600 mb-3">
                Our mission is to provide high-quality gadgets at affordable prices, with a smooth and secure shopping experience.
                Whether you're looking for the newest headphones, phone accessories, or smart home devices, we've got you covered.
            </p>
            <p class="text-gray-600">
                At Cellario, customer satisfaction is our priority. We focus on fast delivery, excellent support, and keeping you updated with the latest tech trends.
            </p>
        </div>
        <div>
            <img src="{{ asset('images/Cellario.png') }}" alt="logo" class="rounded-2xl shadow-lg">
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 text-center">
        <h2 class="text-3xl font-bold mb-12">Meet Our Team</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
            <div class="bg-gray-100 rounded-2xl shadow-md p-6">
                <img src="{{ asset('images/Team01.jpeg') }}" alt="Team Member" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                <h3 class="text-lg font-bold">John Doe</h3>
                <p class="text-gray-500">CEO & Founder</p>
            </div>
            <div class="bg-gray-100 rounded-2xl shadow-md p-6">
                <img src="{{ asset('images/Team02.jpeg') }}" alt="Team Member" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                <h3 class="text-lg font-bold">Jane Smith</h3>
                <p class="text-gray-500">Head of Marketing</p>
            </div>
            <div class="bg-gray-100 rounded-2xl shadow-md p-6">
                <img src="{{ asset('images/Team03.jpeg') }}" alt="Team Member" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                <h3 class="text-lg font-bold">Michael Lee</h3>
                <p class="text-gray-500">Product Manager</p>
            </div>
            <div class="bg-gray-100 rounded-2xl shadow-md p-6">
                <img src="{{ asset('images/Team04.jpeg') }}" alt="Team Member" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                <h3 class="text-lg font-bold">Sarah Connor</h3>
                <p class="text-gray-500">Customer Support</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-12">What Our Clients Say</h2>
        <div class="space-y-8">
            <div class="bg-white p-6 rounded-2xl shadow-md">
                <p class="italic">"Cellario always delivers high-quality products quickly! I love their customer service."</p>
                <span class="block mt-3 font-semibold">- Ayesha Perera</span>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-md">
                <p class="italic">"Best gadget store online! Affordable prices and trustworthy service."</p>
                <span class="block mt-3 font-semibold">- Kasun Fernando</span>
            </div>
        </div>
    </div>
</section>
@endsection
