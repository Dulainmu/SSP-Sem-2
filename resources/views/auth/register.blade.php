<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account - Cellario</title>
  @vite(['resources/css/app.css'])
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">

  <!-- Back to Home Button -->
  <div class="absolute top-4 left-4">
    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
      <i class="fas fa-arrow-left mr-2"></i>
      Back to Home
    </a>
  </div>

  <section class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 items-center bg-white shadow-2xl rounded-3xl overflow-hidden">

      <!-- Left Side - Branding -->
      <div class="hidden lg:flex flex-col justify-center items-center bg-gradient-to-br from-blue-600 to-blue-800 text-white p-12">
        <div class="text-center">
          <img src="{{ asset('images/Cellario.png') }}"
               alt="Cellario Logo"
               class="w-64 h-auto mb-8 mx-auto filter brightness-0 invert">

          <h1 class="text-4xl font-bold mb-4">Join Cellario</h1>
          <p class="text-xl text-blue-100 mb-8">Start your luxury electronics journey</p>

          <div class="grid grid-cols-2 gap-4 text-center">
            <div class="bg-white/10 rounded-lg p-4">
              <i class="fas fa-crown text-3xl mb-2"></i>
              <p class="text-sm">Premium</p>
            </div>
            <div class="bg-white/10 rounded-lg p-4">
              <i class="fas fa-star text-3xl mb-2"></i>
              <p class="text-sm">Exclusive</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Side - Registration Form -->
      <div class="w-full p-8 lg:p-16">
        <div class="max-w-md mx-auto">
          <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">Create Account</h2>
          <p class="text-gray-600 text-center mb-8">Join the luxury electronics community</p>

          @if ($errors->any())
          <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <i class="fas fa-exclamation-circle mr-2"></i>
            @foreach ($errors->all() as $error)
              {{ $error }}<br>
            @endforeach
          </div>
          @endif

          <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Full Name Field -->
            <div>
              <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-user mr-2 text-blue-600"></i>Full Name
              </label>
              <input type="text"
                     id="name"
                     name="name"
                     placeholder="Enter your full name"
                     value="{{ old('name') }}"
                     required
                     autofocus
                     class="w-full border border-gray-300 rounded-xl p-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 hover:border-gray-400">
            </div>

            <!-- Email Address Field -->
            <div>
              <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-envelope mr-2 text-blue-600"></i>Email Address
              </label>
              <input type="email"
                     id="email"
                     name="email"
                     placeholder="Enter your email address"
                     value="{{ old('email') }}"
                     required
                     class="w-full border border-gray-300 rounded-xl p-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 hover:border-gray-400">
            </div>

            <!-- Phone Field -->
            <div>
              <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-phone mr-2 text-blue-600"></i>Phone Number <span class="text-gray-500">(Optional)</span>
              </label>
              <input type="tel"
                     id="phone"
                     name="phone"
                     placeholder="Enter your phone number"
                     value="{{ old('phone') }}"
                     class="w-full border border-gray-300 rounded-xl p-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 hover:border-gray-400">
            </div>

            <!-- Password -->
            <div>
              <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-lock mr-2 text-blue-600"></i>Password
              </label>
              <div class="relative">
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Create a strong password"
                       required
                       class="w-full border border-gray-300 rounded-xl p-4 pr-12 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 hover:border-gray-400">
                <button type="button"
                        onclick="togglePassword('password')"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                  <i class="fas fa-eye" id="password-toggle"></i>
                </button>
              </div>
              <div class="mt-2">
                <div class="text-xs text-gray-600">
                  Password must contain:
                  <ul class="list-disc list-inside mt-1 space-y-1">
                    <li>At least 8 characters</li>
                    <li>Uppercase and lowercase letters</li>
                    <li>Numbers and special characters</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- Confirm Password -->
            <div>
              <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-lock mr-2 text-blue-600"></i>Confirm Password
              </label>
              <div class="relative">
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       placeholder="Confirm your password"
                       required
                       class="w-full border border-gray-300 rounded-xl p-4 pr-12 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 hover:border-gray-400">
                <button type="button"
                        onclick="togglePassword('password_confirmation')"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                  <i class="fas fa-eye" id="password_confirmation-toggle"></i>
                </button>
              </div>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <!-- Terms and Conditions -->
            <div class="flex items-start">
              <input type="checkbox"
                     id="terms"
                     name="terms"
                     required
                     class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
              <label for="terms" class="ml-3 text-sm text-gray-600">
                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-blue-600 hover:underline">'.__('Terms of Service').'</a>',
                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-blue-600 hover:underline">'.__('Privacy Policy').'</a>',
                ]) !!}
              </label>
            </div>
            @endif

            <!-- Create Account Button -->
            <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-lg font-semibold py-4 rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
              <i class="fas fa-user-plus mr-2"></i>Create Account
            </button>

            <!-- Divider -->
            <div class="relative">
              <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
              </div>
              <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Already have an account?</span>
              </div>
            </div>

            <!-- Login Link -->
            <div class="text-center">
              <p class="text-gray-600">
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">Sign In</a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <script>
    function togglePassword(fieldId) {
      const passwordInput = document.getElementById(fieldId);
      const toggleIcon = document.getElementById(fieldId + '-toggle');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      }
    }

    // Real-time password matching validation
    document.getElementById('password_confirmation').addEventListener('input', function() {
      const password = document.getElementById('password').value;
      const confirmPassword = this.value;

      if (confirmPassword && password !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
        this.style.borderColor = '#ef4444';
      } else {
        this.setCustomValidity('');
        this.style.borderColor = '';
      }
    });
  </script>

</body>
</html>
