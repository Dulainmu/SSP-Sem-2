# Celario E-Commerce API Documentation

## Base URL
```
http://localhost:8000/api
```

## Authentication
Most endpoints require authentication using Laravel Sanctum. Include the token in the Authorization header:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

---

## Auth Endpoints

### Register
```http
POST /api/auth/register
```

**Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "1234567890",
  "role": "Customer"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Registration successful",
  "user": {...},
  "token": "1|abcd1234..."
}
```

### Login
```http
POST /api/auth/login
```

**Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

### Logout
```http
POST /api/auth/logout
Authorization: Bearer {token}
```

### Get Current User
```http
GET /api/auth/me
Authorization: Bearer {token}
```

### Update Profile
```http
PUT /api/auth/profile
Authorization: Bearer {token}
```

**Body:**
```json
{
  "name": "John Doe",
  "phone": "1234567890",
  "address": "123 Main St",
  "city": "New York",
  "state": "NY",
  "postal_code": "10001",
  "country": "USA"
}
```

### Change Password
```http
PUT /api/auth/password
Authorization: Bearer {token}
```

**Body:**
```json
{
  "current_password": "oldpassword",
  "new_password": "newpassword123",
  "new_password_confirmation": "newpassword123"
}
```

---

## Product Endpoints

### List Products
```http
GET /api/products
```

**Query Parameters:**
- `category_id` - Filter by category
- `brand_id` - Filter by brand
- `featured` - Filter featured products (true/false)
- `search` - Search in name, description, SKU
- `status` - Filter by status (Active, Inactive, etc.)
- `sort_by` - Sort by field (default: created_at)
- `sort_order` - asc or desc (default: desc)
- `per_page` - Items per page (default: 15)

**Example:**
```
GET /api/products?category_id=1&featured=true&per_page=20
```

### Get Product Details
```http
GET /api/products/{id}
```

### Get Featured Products
```http
GET /api/products/featured
```

### Create Product (Admin Only)
```http
POST /api/admin/products
Authorization: Bearer {admin_token}
```

**Body:**
```json
{
  "name": "Product Name",
  "description": "Product description",
  "short_description": "Short description",
  "sku": "PROD-001",
  "category_id": 1,
  "brand_id": 1,
  "price": 99.99,
  "compare_price": 129.99,
  "stock_quantity": 100,
  "min_stock_level": 10,
  "weight": 1.5,
  "is_featured": true,
  "status": "Active"
}
```

### Update Product (Admin Only)
```http
PUT /api/admin/products/{id}
Authorization: Bearer {admin_token}
```

### Delete Product (Admin Only)
```http
DELETE /api/admin/products/{id}
Authorization: Bearer {admin_token}
```

---

## Category Endpoints

### List Categories
```http
GET /api/categories
```

### Get Category Details
```http
GET /api/categories/{id}
```

### Create Category (Admin Only)
```http
POST /api/admin/categories
Authorization: Bearer {admin_token}
```

**Body:**
```json
{
  "name": "Electronics",
  "description": "Electronic products",
  "parent_id": null,
  "sort_order": 1,
  "is_active": true
}
```

---

## Brand Endpoints

### List Brands
```http
GET /api/brands
```

### Get Brand Details
```http
GET /api/brands/{id}
```

### Create Brand (Admin Only)
```http
POST /api/admin/brands
Authorization: Bearer {admin_token}
```

**Body:**
```json
{
  "name": "Apple",
  "description": "Apple Inc.",
  "website_url": "https://apple.com",
  "is_active": true
}
```

---

## Cart Endpoints

### Get Cart
```http
GET /api/cart
```

### Add to Cart
```http
POST /api/cart
```

**Body:**
```json
{
  "product_id": 1,
  "quantity": 2
}
```

### Update Cart Item
```http
PUT /api/cart/{cart_item_id}
```

**Body:**
```json
{
  "quantity": 3
}
```

### Remove from Cart
```http
DELETE /api/cart/{cart_item_id}
```

### Clear Cart
```http
DELETE /api/cart
```

### Get Cart Count
```http
GET /api/cart/count
```

---

## Order Endpoints

### List Orders
```http
GET /api/orders
Authorization: Bearer {token}
```

### Create Order
```http
POST /api/orders
Authorization: Bearer {token}
```

**Body:**
```json
{
  "payment_method": "Credit Card",
  "shipping_method": "Standard Shipping",
  "billing_first_name": "John",
  "billing_last_name": "Doe",
  "billing_address_1": "123 Main St",
  "billing_city": "New York",
  "billing_state": "NY",
  "billing_postal_code": "10001",
  "billing_country": "USA",
  "billing_email": "john@example.com",
  "billing_phone": "1234567890",
  "shipping_first_name": "John",
  "shipping_last_name": "Doe",
  "shipping_address_1": "123 Main St",
  "shipping_city": "New York",
  "shipping_state": "NY",
  "shipping_postal_code": "10001",
  "shipping_country": "USA",
  "notes": "Please ring doorbell"
}
```

### Get Order Details
```http
GET /api/orders/{id}
Authorization: Bearer {token}
```

### Update Order Status (Admin Only)
```http
PUT /api/orders/{id}/status
Authorization: Bearer {admin_token}
```

**Body:**
```json
{
  "status": "Shipped",
  "tracking_number": "TRACK123456"
}
```

**Status Options:** Pending, Processing, Shipped, Delivered, Cancelled, Refunded

---

## Wishlist Endpoints

### Get Wishlist
```http
GET /api/wishlist
Authorization: Bearer {token}
```

### Add to Wishlist
```http
POST /api/wishlist
Authorization: Bearer {token}
```

**Body:**
```json
{
  "product_id": 1
}
```

### Remove from Wishlist
```http
DELETE /api/wishlist/{product_id}
Authorization: Bearer {token}
```

### Clear Wishlist
```http
DELETE /api/wishlist
Authorization: Bearer {token}
```

---

## Review Endpoints

### Get Product Reviews
```http
GET /api/products/{product_id}/reviews
```

### Create Review
```http
POST /api/reviews
Authorization: Bearer {token}
```

**Body:**
```json
{
  "product_id": 1,
  "rating": 5,
  "title": "Great product!",
  "comment": "I really love this product. Highly recommended!"
}
```

### Update Review
```http
PUT /api/reviews/{id}
Authorization: Bearer {token}
```

### Delete Review
```http
DELETE /api/reviews/{id}
Authorization: Bearer {token}
```

### Mark Review as Helpful
```http
POST /api/reviews/{id}/helpful
Authorization: Bearer {token}
```

---

## Coupon Endpoints

### Validate Coupon
```http
POST /api/coupons/validate
```

**Body:**
```json
{
  "code": "SUMMER2024",
  "subtotal": 100.00
}
```

**Response:**
```json
{
  "success": true,
  "message": "Coupon applied successfully",
  "data": {
    "coupon": {...},
    "discount": 10.00,
    "type": "Percentage"
  }
}
```

### List Coupons (Admin Only)
```http
GET /api/admin/coupons
Authorization: Bearer {admin_token}
```

### Create Coupon (Admin Only)
```http
POST /api/admin/coupons
Authorization: Bearer {admin_token}
```

**Body:**
```json
{
  "code": "SUMMER2024",
  "type": "Percentage",
  "amount": 10,
  "minimum_amount": 50,
  "usage_limit": 100,
  "expires_at": "2024-12-31",
  "is_active": true
}
```

**Coupon Types:**
- `Percentage` - Percentage discount
- `Fixed Amount` - Fixed dollar amount discount
- `Free Shipping` - Free shipping

---

## Response Format

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {...}
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message",
  "errors": {...}
}
```

### Validation Error Response
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "field_name": ["Error message"]
  }
}
```

---

## Status Codes

- `200` - OK
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Server Error

---

## Rate Limiting

API requests are rate limited to prevent abuse. Default limits:
- Authenticated users: 60 requests per minute
- Guest users: 30 requests per minute

---

## Notes

1. All timestamps are in UTC
2. Prices are in USD (configurable)
3. All endpoints return JSON responses
4. Session-based cart works for both guests and authenticated users
5. Admin endpoints require admin role
