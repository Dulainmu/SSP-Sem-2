<header class="bg-blue-600 text-white">
    <div class="container mx-auto flex items-center justify-between py-4 px-6">
      <div class="text-2xl font-bold italic">Cellario</div>
      <nav>
        <ul class="flex space-x-6 font-medium">
          <li><a href="/Assignment/" class="hover:text-blue-200">Home</a></li>
          <li><a href="/Assignment/About" class="hover:text-blue-200">About Us</a></li>
          <li><a href="/Assignment/Products" class="hover:text-blue-200">Products</a></li>
          <li><a href="/Assignment/Contact" class="hover:text-blue-200">Contact Us</a></li>
        </ul>
      </nav>
      <div class="flex items-center space-x-4">
        <?php if (Security::isLoggedIn()): ?>
          <!-- Logged in user menu -->
          <div class="relative group">
            <button class="flex items-center space-x-2 hover:text-blue-200">
              <i class="fas fa-user"></i>
              <span class="hidden md:inline"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
              <i class="fas fa-chevron-down text-sm"></i>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden group-hover:block">
              <?php if ($_SESSION['user_role'] === 'Admin'): ?>
                <a href="/Assignment/Admin/Dashboard" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  <i class="fas fa-tachometer-alt mr-2"></i>Admin Dashboard
                </a>
              <?php else: ?>
                <a href="/Assignment/Edit Profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  <i class="fas fa-user-edit mr-2"></i>Edit Profile
                </a>
              <?php endif; ?>
              <a href="/Assignment/Logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-sign-out-alt mr-2"></i>Logout
              </a>
            </div>
          </div>
        <?php else: ?>
          <!-- Guest user buttons -->
          <a href="/Assignment/Login" class="hover:text-blue-200" title="Login">
            <i class="fas fa-user text-xl"></i>
          </a>
        <?php endif; ?>

        <?php if (Security::isLoggedIn()): ?>
          <a href="/Assignment/Wishlist" class="hover:text-blue-200" title="Wishlist">
            <i class="fas fa-heart text-xl"></i>
          </a>
        <?php endif; ?>

        <a href="/Assignment/Cart" class="hover:text-blue-200 relative" title="View Cart">
          <i class="fas fa-shopping-cart text-xl"></i>
          <?php if (Security::isLoggedIn()): ?>
            <span class="ml-1 bg-blue-800 text-xs px-2 py-1 rounded-full cart-count-badge">
              <?php
              try {
                $cart = new Cart();
                $cartItems = $cart->getCartItems($_SESSION['user_id']);
                echo count($cartItems);
              } catch (Exception $e) {
                echo '0';
              }
              ?>
            </span>
          <?php endif; ?>
        </a>
      </div>
    </div>
  </header>