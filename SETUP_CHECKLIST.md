# Setup Checklist for Celario Laravel Project

Follow these steps to get your Laravel e-commerce platform up and running:

## ✅ Prerequisites Check

- [ ] PHP 8.2 or higher installed
- [ ] Composer installed
- [ ] MySQL 8.0 or higher installed and running
- [ ] Node.js and NPM installed (for frontend assets)
- [ ] Git installed (optional)

## 🚀 Setup Steps

### 1. Navigate to Project
```bash
cd celario
```

### 2. Install PHP Dependencies
```bash
composer install
```
- [ ] Composer dependencies installed successfully

### 3. Install Node Dependencies
```bash
npm install
```
- [ ] NPM packages installed successfully

### 4. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```
- [ ] `.env` file created
- [ ] Application key generated

### 5. Configure Database

Edit `.env` file and set database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cellario_ecommerce
DB_USERNAME=root
DB_PASSWORD=your_password
```
- [ ] Database credentials configured

### 6. Create Database

In MySQL/phpMyAdmin:
```sql
CREATE DATABASE cellario_ecommerce CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
- [ ] Database created

### 7. Run Migrations
```bash
php artisan migrate
```
- [ ] All 12 tables created successfully
  - [ ] users (modified)
  - [ ] categories
  - [ ] brands
  - [ ] products
  - [ ] product_attributes
  - [ ] orders
  - [ ] order_items
  - [ ] cart_items
  - [ ] coupons
  - [ ] reviews
  - [ ] wishlist
  - [ ] settings

### 8. Seed Sample Data
```bash
php artisan db:seed
```
- [ ] Sample data seeded successfully
- [ ] Admin user created (admin@celario.com)
- [ ] Customer user created (customer@example.com)
- [ ] Sample products created
- [ ] Sample categories created
- [ ] Sample coupons created

### 9. Create Storage Link
```bash
php artisan storage:link
```
- [ ] Storage link created

### 10. Build Frontend Assets
```bash
# For development
npm run dev

# OR for production
npm run build
```
- [ ] Frontend assets compiled

### 11. Start Development Server
```bash
php artisan serve
```
- [ ] Server started successfully at http://localhost:8000

## 🧪 Testing the API

### Test 1: Health Check
```bash
curl http://localhost:8000/up
```
- [ ] Health check returns 200 OK

### Test 2: Get Products (Public)
```bash
curl http://localhost:8000/api/products
```
- [ ] Products list returned successfully

### Test 3: Admin Login
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@celario.com","password":"admin123"}'
```
- [ ] Login successful
- [ ] Token received
- [ ] Save this token for authenticated requests

### Test 4: Get User Profile (Authenticated)
```bash
curl http://localhost:8000/api/auth/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```
- [ ] User profile returned

### Test 5: Add to Cart (Public)
```bash
curl -X POST http://localhost:8000/api/cart \
  -H "Content-Type: application/json" \
  -d '{"product_id":1,"quantity":1}'
```
- [ ] Product added to cart

## 📋 Optional Setup

### Enable Query Logging (Development)
In `app/Providers/AppServiceProvider.php`:
```php
use Illuminate\Support\Facades\DB;

public function boot()
{
    if (app()->environment('local')) {
        DB::listen(function($query) {
            logger($query->sql, $query->bindings);
        });
    }
}
```
- [ ] Query logging enabled

### Setup Queue Worker (for emails, etc.)
```bash
php artisan queue:table
php artisan migrate
php artisan queue:work
```
- [ ] Queue configured

### Setup Scheduled Tasks (for cron jobs)
Add to crontab:
```
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```
- [ ] Scheduler configured

## 🔍 Troubleshooting

### If migrations fail:
```bash
php artisan migrate:fresh
php artisan db:seed
```

### If cache issues occur:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### If permission errors (Windows):
Run PowerShell as Administrator:
```powershell
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T
```

### If database connection fails:
- [ ] MySQL service is running
- [ ] Database credentials in `.env` are correct
- [ ] Database exists
- [ ] User has proper privileges

## 📚 Documentation Reference

- [ ] Read [MIGRATION_GUIDE.md](MIGRATION_GUIDE.md)
- [ ] Review [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
- [ ] Check [QUICK_START.md](QUICK_START.md)

## 🎓 Test Credentials

**Admin:**
- Email: `admin@celario.com`
- Password: `admin123`

**Customer:**
- Email: `customer@example.com`
- Password: `password123`

## ✅ Final Checks

- [ ] Application runs without errors
- [ ] Can access http://localhost:8000
- [ ] API endpoints respond correctly
- [ ] Authentication works
- [ ] Database has sample data
- [ ] All tests pass

## 🎉 Ready!

If all checkboxes are checked, your Laravel e-commerce platform is ready to use!

### Next Steps:
1. Start building your frontend
2. Customize the business logic
3. Add more features
4. Deploy to production

---

**Need help?** Check the documentation files or review the error logs in `storage/logs/`.
