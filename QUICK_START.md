# Celario E-Commerce Platform - Quick Setup

## Quick Start (Windows)

Run this in PowerShell from the celario directory:

```powershell
# Install dependencies
composer install
npm install

# Setup environment
Copy-Item .env.example .env

# Generate application key
php artisan key:generate

# Create database (run MySQL commands)
# CREATE DATABASE cellario_ecommerce;

# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed

# Create storage link
php artisan storage:link

# Build assets
npm run dev

# Start server
php artisan serve
```

## Test Credentials

After seeding:
- **Admin**: admin@celario.com / admin123
- **Customer**: customer@example.com / password123

## Quick Test

1. Start the server:
   ```bash
   php artisan serve
   ```

2. Test login:
   ```bash
   curl -X POST http://localhost:8000/api/auth/login \
     -H "Content-Type: application/json" \
     -d '{"email":"admin@celario.com","password":"admin123"}'
   ```

3. Get products:
   ```bash
   curl http://localhost:8000/api/products
   ```

## What's Included in Seed Data

- 2 Users (1 Admin, 1 Customer)
- 4 Categories (Electronics with sub-categories)
- 3 Brands (Apple, Samsung, Dell)
- 5 Products (Phones and Laptops)
- 3 Coupons (WELCOME10, SAVE20, FREESHIP)

## API Testing

Use the included API_DOCUMENTATION.md for complete API reference.

## Troubleshooting

### Database Connection Error
- Make sure MySQL is running
- Check DB credentials in .env
- Create the database: `CREATE DATABASE cellario_ecommerce;`

### Permission Errors
```bash
# Windows (Run as Administrator if needed)
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T
```

### Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

## Next Steps

1. Review [MIGRATION_GUIDE.md](MIGRATION_GUIDE.md) for complete documentation
2. Check [API_DOCUMENTATION.md](API_DOCUMENTATION.md) for API endpoints
3. Start building your frontend!
