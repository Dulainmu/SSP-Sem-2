# Celario E-Commerce Platform - Laravel Migration

This is the Laravel migration of the PHP-based Ramiru e-commerce project. The project has been completely rebuilt using Laravel 11 with modern best practices.

## 🚀 What Has Been Migrated

### ✅ Database Structure
- **Users** - With roles (Admin/Customer), profiles, and authentication
- **Products** - With categories, brands, attributes, and inventory management
- **Categories** - Hierarchical category structure
- **Brands** - Product brand management
- **Orders** - Complete order management with billing/shipping addresses
- **Order Items** - Individual items in orders
- **Cart** - Shopping cart functionality (session and user-based)
- **Coupons** - Discount codes with various types
- **Reviews** - Product reviews and ratings
- **Wishlist** - User wishlist functionality
- **Settings** - Application settings storage

### ✅ API Endpoints

All API endpoints have been migrated to Laravel controllers with proper authentication and authorization:

#### Public Endpoints
- `POST /api/auth/register` - User registration
- `POST /api/auth/login` - User login
- `GET /api/products` - List products (with filters, search, pagination)
- `GET /api/products/featured` - Featured products
- `GET /api/products/{id}` - Product details
- `GET /api/categories` - List categories
- `GET /api/categories/{id}` - Category details
- `GET /api/brands` - List brands
- `GET /api/brands/{id}` - Brand details
- `GET /api/products/{productId}/reviews` - Product reviews
- `GET/POST/PUT/DELETE /api/cart` - Cart operations
- `POST /api/coupons/validate` - Validate coupon code

#### Authenticated Endpoints
- `POST /api/auth/logout` - Logout
- `GET /api/auth/me` - Get user profile
- `PUT /api/auth/profile` - Update profile
- `PUT /api/auth/password` - Change password
- `GET/POST/DELETE /api/wishlist` - Wishlist operations
- `POST/PUT/DELETE /api/reviews` - Review operations
- `GET/POST /api/orders` - Order operations
- `GET /api/orders/{id}` - Order details

#### Admin Endpoints
- `POST/PUT/DELETE /api/admin/products` - Product management
- `POST/PUT/DELETE /api/admin/categories` - Category management
- `POST/PUT/DELETE /api/admin/brands` - Brand management
- `GET/POST/PUT/DELETE /api/admin/coupons` - Coupon management
- `PUT /api/admin/orders/{id}/status` - Update order status

## 📋 Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL 8.0 or higher
- Node.js & NPM (for frontend assets)

## 🛠️ Installation Steps

### 1. Clone and Setup

```bash
cd celario
composer install
npm install
```

### 2. Environment Configuration

```bash
cp .env.example .env
```

Edit `.env` file:

```env
APP_NAME=Celario
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cellario_ecommerce
DB_USERNAME=root
DB_PASSWORD=

# Session driver for cart functionality
SESSION_DRIVER=database
```

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Create Database

Create a MySQL database named `cellario_ecommerce`:

```sql
CREATE DATABASE cellario_ecommerce CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Run Migrations

```bash
php artisan migrate
```

This will create all the necessary tables.

### 6. Seed Database (Optional)

You can create a seeder to populate initial data:

```bash
php artisan db:seed
```

### 7. Create Storage Link

```bash
php artisan storage:link
```

### 8. Build Frontend Assets

```bash
npm run dev
# or for production
npm run build
```

### 9. Start Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## 🔐 Authentication

This project uses Laravel Sanctum for API authentication. 

### Getting an API Token

1. Register a new user:
```bash
POST /api/auth/register
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

2. Login:
```bash
POST /api/auth/login
{
  "email": "john@example.com",
  "password": "password123"
}
```

You'll receive a token in the response. Use this token in the `Authorization` header:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

## 📚 Key Features

### User Management
- Registration and login with Laravel Sanctum
- Role-based access control (Admin/Customer)
- Profile management
- Password change functionality

### Product Management
- Full CRUD operations (Admin only)
- Product attributes and variations
- Inventory tracking
- Featured products
- Product search and filtering
- Categories and brands

### Shopping Cart
- Session-based cart for guests
- User-based cart for authenticated users
- Real-time stock validation
- Cart persistence

### Order Management
- Complete checkout process
- Order tracking
- Order status management (Admin)
- Billing and shipping addresses
- Multiple payment methods support

### Reviews & Ratings
- Product reviews with ratings (1-5 stars)
- Verified purchase badges
- Review moderation (Admin)
- Helpful review voting

### Coupons & Discounts
- Percentage discounts
- Fixed amount discounts
- Free shipping coupons
- Usage limits and expiration dates
- Minimum order amount requirements

### Wishlist
- Save products for later
- Easy add to cart from wishlist

## 🔄 Key Differences from PHP Version

1. **Framework**: Migrated from vanilla PHP to Laravel 11
2. **Authentication**: Using Laravel Sanctum instead of custom session management
3. **Database**: Using Eloquent ORM instead of raw PDO
4. **Routing**: Laravel routing instead of custom routing
5. **Validation**: Using Laravel's built-in validation
6. **Security**: Laravel's built-in CSRF protection, password hashing
7. **API Structure**: RESTful API with proper HTTP methods
8. **Code Organization**: MVC architecture with clear separation of concerns

## 📁 Project Structure

```
celario/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── AuthController.php
│   │   │       ├── ProductController.php
│   │   │       ├── CartController.php
│   │   │       ├── OrderController.php
│   │   │       ├── WishlistController.php
│   │   │       ├── ReviewController.php
│   │   │       ├── CouponController.php
│   │   │       ├── CategoryController.php
│   │   │       └── BrandController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Product.php
│       ├── Category.php
│       ├── Brand.php
│       ├── Order.php
│       ├── OrderItem.php
│       ├── CartItem.php
│       ├── Coupon.php
│       ├── Review.php
│       ├── Wishlist.php
│       └── Setting.php
├── database/
│   └── migrations/
│       ├── 2024_01_01_000001_add_ecommerce_fields_to_users_table.php
│       ├── 2024_01_02_000000_create_categories_table.php
│       ├── 2024_01_03_000000_create_brands_table.php
│       ├── 2024_01_04_000000_create_products_table.php
│       ├── 2024_01_05_000000_create_product_attributes_table.php
│       ├── 2024_01_06_000000_create_orders_table.php
│       ├── 2024_01_07_000000_create_order_items_table.php
│       ├── 2024_01_08_000000_create_cart_items_table.php
│       ├── 2024_01_09_000000_create_coupons_table.php
│       ├── 2024_01_10_000000_create_reviews_table.php
│       ├── 2024_01_11_000000_create_wishlist_table.php
│       └── 2024_01_12_000000_create_settings_table.php
└── routes/
    └── api.php
```

## 🧪 Testing

Run tests with:

```bash
php artisan test
```

## 📝 API Testing with Postman/Insomnia

A complete API collection is available for testing. Import the collection and set:
- Base URL: `http://localhost:8000/api`
- Authorization: Bearer Token (after login)

## 🔧 Configuration

### CORS Configuration

If you're building a separate frontend, enable CORS in `config/cors.php`:

```php
'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:3000'], // Your frontend URL
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'supports_credentials' => true,
```

### Session Configuration

For cart functionality to work with guests, ensure session driver is set to `database` or `file`:

```bash
php artisan session:table
php artisan migrate
```

## 🚀 Deployment

### Production Checklist

1. Set `APP_ENV=production` and `APP_DEBUG=false`
2. Generate new `APP_KEY`
3. Configure production database
4. Run `composer install --optimize-autoloader --no-dev`
5. Run `php artisan config:cache`
6. Run `php artisan route:cache`
7. Run `php artisan view:cache`
8. Set up proper file permissions
9. Configure your web server (Apache/Nginx)
10. Enable HTTPS

## 📞 Support

For issues or questions, please check the documentation or create an issue in the repository.

## 📄 License

This project is open-source and available under the MIT License.

---

**Migration completed successfully! 🎉**

All PHP functionality has been migrated to Laravel with modern best practices, improved security, and better code organization.
