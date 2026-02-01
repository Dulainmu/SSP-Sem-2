@extends('layouts.app')

@section('title', 'My Profile - Celario')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">My Profile</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <ul class="space-y-2">
                    <li><a href="{{ route('profile') }}" class="block px-4 py-2 rounded bg-indigo-50 text-indigo-600 font-semibold">Profile</a></li>
                    <li><a href="{{ route('orders') }}" class="block px-4 py-2 rounded hover:bg-gray-50">Orders</a></li>
                    <li><a href="{{ route('wishlist') }}" class="block px-4 py-2 rounded hover:bg-gray-50">Wishlist</a></li>
                    <li><button onclick="logout()" class="block w-full text-left px-4 py-2 rounded hover:bg-gray-50 text-red-600">Logout</button></li>
                </ul>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-6">Personal Information</h2>
                
                <form id="profile-form" onsubmit="updateProfile(event)">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium">Full Name</label>
                            <input type="text" name="name" id="name" required 
                                   class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">Email</label>
                            <input type="email" name="email" id="email" required 
                                   class="w-full border rounded-lg px-4 py-2">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium">Phone</label>
                        <input type="tel" name="phone" id="phone" 
                               class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium">Address</label>
                        <textarea name="address" id="address" rows="3" 
                                  class="w-full border rounded-lg px-4 py-2"></textarea>
                    </div>
                    
                    <button type="submit" 
                            class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                        Update Profile
                    </button>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h2 class="text-xl font-bold mb-6">Change Password</h2>
                
                <form id="password-form" onsubmit="changePassword(event)">
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium">Current Password</label>
                        <input type="password" name="current_password" required 
                               class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium">New Password</label>
                        <input type="password" name="new_password" required minlength="8"
                               class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" required 
                               class="w-full border rounded-lg px-4 py-2">
                    </div>
                    
                    <button type="submit" 
                            class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                        Change Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Load profile data
async function loadProfile() {
    if (!authToken) {
        window.location.href = '/login';
        return;
    }
    
    try {
        const response = await fetch(`${API_URL}/auth/user`, {
            headers: {
                'Authorization': `Bearer ${authToken}`
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            const user = data.data;
            document.getElementById('name').value = user.name || '';
            document.getElementById('email').value = user.email || '';
            document.getElementById('phone').value = user.phone || '';
            document.getElementById('address').value = user.address || '';
        }
    } catch (error) {
        console.error('Error loading profile:', error);
    }
}

// Update profile
async function updateProfile(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    try {
        const response = await fetch(`${API_URL}/auth/profile`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify({
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                address: formData.get('address')
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Profile updated successfully!');
        } else {
            alert(data.message || 'Failed to update profile');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to update profile');
    }
}

// Change password
async function changePassword(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    if (formData.get('new_password') !== formData.get('new_password_confirmation')) {
        alert('New passwords do not match');
        return;
    }
    
    try {
        const response = await fetch(`${API_URL}/auth/change-password`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify({
                current_password: formData.get('current_password'),
                new_password: formData.get('new_password'),
                new_password_confirmation: formData.get('new_password_confirmation')
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Password changed successfully!');
            form.reset();
        } else {
            alert(data.message || 'Failed to change password');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to change password');
    }
}

// Load profile on page load
document.addEventListener('DOMContentLoaded', loadProfile);
</script>
@endpush
@endsection
