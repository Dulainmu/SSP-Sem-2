<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Cellario</title>
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

          <h1 class="text-4xl font-bold mb-4">Welcome Back</h1>
          <p class="text-xl text-blue-100 mb-8">Access your luxury electronics collection</p>

          <div class="grid grid-cols-2 gap-4 text-center">
            <div class="bg-white/10 rounded-lg p-4">
              <i class="fas fa-shield-alt text-3xl mb-2"></i>
              <p class="text-sm">Secure</p>
            </div>
            <div class="bg-white/10 rounded-lg p-4">
              <i class="fas fa-bolt text-3xl mb-2"></i>
              <p class="text-sm">Fast</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Side - Login Form -->
      <div class="w-full p-8 lg:p-16">
        <div class="max-w-md mx-auto">
          <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">Sign In</h2>
          <p class="text-gray-600 text-center mb-8">Enter your credentials to access your account</p>

          @if ($errors->any())
          <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <i class="fas fa-exclamation-circle mr-2"></i>
            @foreach ($errors->all() as $error)
              {{ $error }}
            @endforeach
          </div>
          @endif

          @session('status')
          <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            <i class="fas fa-check-circle mr-2"></i>{{ $value }}
          </div>
          @endsession

          <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

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
                     autofocus
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
                       placeholder="Enter your password"
                       required
                       class="w-full border border-gray-300 rounded-xl p-4 pr-12 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 hover:border-gray-400">
                <button type="button"
                        onclick="togglePassword()"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                  <i class="fas fa-eye" id="password-toggle"></i>
                </button>
              </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
              <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
              </label>
              @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">Forgot password?</a>
              @endif
            </div>

            <!-- Login Button -->
            <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-lg font-semibold py-4 rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
              <i class="fas fa-sign-in-alt mr-2"></i>Sign In
            </button>

            <!-- Divider -->
            <div class="relative">
              <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
              </div>
              <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">New to Cellario?</span>
              </div>
            </div>

            <!-- Sign Up Link -->
            <div class="text-center">
              <p class="text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">Create Account</a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.getElementById('password-toggle');

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
  </script>

</body>
</html>
