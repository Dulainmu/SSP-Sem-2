-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2026 at 07:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cellario_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `description`, `logo_url`, `website_url`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Apple', 'Innovation and premium technology products', NULL, 'https://www.apple.com', 1, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(2, 'Samsung', 'Leading technology and electronics manufacturer', NULL, 'https://www.samsung.com', 1, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(3, 'Sony', 'Premium electronics and entertainment', NULL, 'https://www.sony.com', 1, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(4, 'Dell', 'Computer technology and solutions', NULL, 'https://www.dell.com', 1, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(5, 'HP', 'Computing and printing solutions', NULL, 'https://www.hp.com', 1, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(6, 'Lenovo', 'Intelligent technology for everyone', NULL, 'https://www.lenovo.com', 1, '2025-09-30 04:42:08', '2025-09-30 04:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `session_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 5, NULL, 2, 1, '2025-09-30 05:13:29', '2025-09-30 05:13:29'),
(2, 5, NULL, 1, 1, '2025-09-30 05:14:06', '2025-09-30 05:14:06'),
(3, NULL, 'f594pvoh6gvcubk6bji9isltg0', 9, 1, '2025-09-30 06:00:50', '2025-09-30 06:00:50'),
(4, 6, NULL, 9, 1, '2025-09-30 06:04:44', '2025-09-30 06:04:44'),
(5, 6, NULL, 10, 2, '2025-09-30 10:56:35', '2025-09-30 10:56:41');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image_url`, `parent_id`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Smartphones', 'Latest smartphones and mobile devices', 'src/images/SmartphoneCategeory.png', NULL, 0, 1, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(2, 'Laptops', 'High-performance laptops and notebooks', 'src/images/LaptopCategeory.jpg', NULL, 0, 1, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(3, 'Headphones', 'Premium audio equipment and headphones', 'src/images/HeadphoneCategeory.jpg', NULL, 0, 1, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(4, 'Smart Watches', 'Smartwatches and wearable technology', 'src/images/smartwatchIcon.png', NULL, 0, 1, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(5, 'Tablets', 'Tablets and portable computing devices', 'src/images/TabletIcon.png', NULL, 0, 1, '2025-09-30 04:42:08', '2025-09-30 04:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `type` enum('Percentage','Fixed Amount','Free Shipping') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `minimum_amount` decimal(10,2) DEFAULT 0.00,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) DEFAULT 0,
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `amount`, `minimum_amount`, `usage_limit`, `used_count`, `expires_at`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'WELCOME10', 'Percentage', 10.00, 50.00, 100, 0, '2025-12-31 18:29:59', 1, '2025-09-30 04:42:09', '2025-09-30 04:42:09'),
(2, 'FREESHIP', 'Free Shipping', 0.00, 25.00, NULL, 0, '2025-12-31 18:29:59', 1, '2025-09-30 04:42:09', '2025-09-30 04:42:09'),
(3, 'SAVE50', 'Fixed Amount', 50.00, 200.00, 50, 0, '2025-12-31 18:29:59', 1, '2025-09-30 04:42:09', '2025-09-30 04:42:09');

-- --------------------------------------------------------

--
-- Stand-in structure for view `low_stock_products`
-- (See below for the actual view)
--
CREATE TABLE `low_stock_products` (
`id` int(11)
,`name` varchar(255)
,`description` text
,`short_description` varchar(500)
,`sku` varchar(100)
,`barcode` varchar(100)
,`category_id` int(11)
,`brand_id` int(11)
,`price` decimal(10,2)
,`compare_price` decimal(10,2)
,`cost_price` decimal(10,2)
,`stock_quantity` int(11)
,`min_stock_level` int(11)
,`weight` decimal(8,3)
,`dimensions` varchar(100)
,`image_url` varchar(255)
,`gallery` text
,`is_featured` tinyint(1)
,`is_digital` tinyint(1)
,`requires_shipping` tinyint(1)
,`tax_status` enum('Taxable','Shipping only','None')
,`tax_class` varchar(50)
,`status` enum('Active','Inactive','Draft','Out of Stock')
,`visibility` enum('Visible','Hidden','Password Protected')
,`meta_title` varchar(255)
,`meta_description` text
,`created_at` timestamp
,`updated_at` timestamp
,`category_name` varchar(255)
,`brand_name` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('Pending','Processing','Shipped','Delivered','Cancelled','Refunded') DEFAULT 'Pending',
  `currency` varchar(3) DEFAULT 'USD',
  `subtotal` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) DEFAULT 0.00,
  `shipping_amount` decimal(10,2) DEFAULT 0.00,
  `discount_amount` decimal(10,2) DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('Credit Card','PayPal','Bank Transfer','Cash on Delivery') DEFAULT 'Credit Card',
  `payment_status` enum('Pending','Paid','Failed','Refunded') DEFAULT 'Pending',
  `shipping_method` varchar(100) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `billing_first_name` varchar(100) DEFAULT NULL,
  `billing_last_name` varchar(100) DEFAULT NULL,
  `billing_company` varchar(100) DEFAULT NULL,
  `billing_address_1` varchar(255) DEFAULT NULL,
  `billing_address_2` varchar(255) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_state` varchar(100) DEFAULT NULL,
  `billing_postal_code` varchar(20) DEFAULT NULL,
  `billing_country` varchar(100) DEFAULT NULL,
  `billing_email` varchar(255) DEFAULT NULL,
  `billing_phone` varchar(20) DEFAULT NULL,
  `shipping_first_name` varchar(100) DEFAULT NULL,
  `shipping_last_name` varchar(100) DEFAULT NULL,
  `shipping_company` varchar(100) DEFAULT NULL,
  `shipping_address_1` varchar(255) DEFAULT NULL,
  `shipping_address_2` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_state` varchar(100) DEFAULT NULL,
  `shipping_postal_code` varchar(20) DEFAULT NULL,
  `shipping_country` varchar(100) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `shipped_date` timestamp NULL DEFAULT NULL,
  `delivered_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `status`, `currency`, `subtotal`, `tax_amount`, `shipping_amount`, `discount_amount`, `total_amount`, `payment_method`, `payment_status`, `shipping_method`, `tracking_number`, `notes`, `billing_first_name`, `billing_last_name`, `billing_company`, `billing_address_1`, `billing_address_2`, `billing_city`, `billing_state`, `billing_postal_code`, `billing_country`, `billing_email`, `billing_phone`, `shipping_first_name`, `shipping_last_name`, `shipping_company`, `shipping_address_1`, `shipping_address_2`, `shipping_city`, `shipping_state`, `shipping_postal_code`, `shipping_country`, `order_date`, `shipped_date`, `delivered_date`, `created_at`, `updated_at`) VALUES
(1, 'ORD-001001', 2, '', 'USD', 299.99, 24.00, 9.99, 0.00, 333.98, 'Credit Card', 'Paid', NULL, NULL, NULL, 'John', 'Doe', NULL, '123 Main St', NULL, 'New York', 'NY', '10001', 'USA', 'john@example.com', '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-30 04:42:08', NULL, NULL, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(2, 'ORD-001002', 3, 'Pending', 'USD', 149.50, 11.96, 7.99, 0.00, 169.45, 'PayPal', 'Pending', NULL, NULL, NULL, 'Jane', 'Smith', NULL, '456 Oak Ave', NULL, 'Los Angeles', 'CA', '90001', 'USA', 'jane@example.com', '0987654321', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-30 04:42:08', NULL, NULL, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(3, 'ORD-001003', 4, 'Processing', 'USD', 599.00, 47.92, 0.00, 0.00, 646.92, 'Credit Card', 'Paid', NULL, NULL, NULL, 'Mike', 'Johnson', NULL, '789 Pine Rd', NULL, 'Chicago', 'IL', '60601', 'USA', 'mike@example.com', '5555551234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-30 04:42:08', NULL, NULL, '2025-09-30 04:42:08', '2025-09-30 04:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_sku` varchar(100) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_sku`, `quantity`, `price`, `total`, `created_at`) VALUES
(1, 1, 3, 'AirPods Pro', 'APP-2ND-GEN', 1, 249.00, 249.00, '2025-09-30 04:42:08'),
(2, 2, 3, 'AirPods Pro', 'APP-2ND-GEN', 1, 149.50, 149.50, '2025-09-30 04:42:08'),
(3, 3, 4, 'Apple Watch Series 9', 'AWS9-45-MID', 1, 399.00, 399.00, '2025-09-30 04:42:08');

-- --------------------------------------------------------

--
-- Stand-in structure for view `order_summary`
-- (See below for the actual view)
--
CREATE TABLE `order_summary` (
`id` int(11)
,`order_number` varchar(50)
,`user_id` int(11)
,`status` enum('Pending','Processing','Shipped','Delivered','Cancelled','Refunded')
,`currency` varchar(3)
,`subtotal` decimal(10,2)
,`tax_amount` decimal(10,2)
,`shipping_amount` decimal(10,2)
,`discount_amount` decimal(10,2)
,`total_amount` decimal(10,2)
,`payment_method` enum('Credit Card','PayPal','Bank Transfer','Cash on Delivery')
,`payment_status` enum('Pending','Paid','Failed','Refunded')
,`shipping_method` varchar(100)
,`tracking_number` varchar(100)
,`notes` text
,`billing_first_name` varchar(100)
,`billing_last_name` varchar(100)
,`billing_company` varchar(100)
,`billing_address_1` varchar(255)
,`billing_address_2` varchar(255)
,`billing_city` varchar(100)
,`billing_state` varchar(100)
,`billing_postal_code` varchar(20)
,`billing_country` varchar(100)
,`billing_email` varchar(255)
,`billing_phone` varchar(20)
,`shipping_first_name` varchar(100)
,`shipping_last_name` varchar(100)
,`shipping_company` varchar(100)
,`shipping_address_1` varchar(255)
,`shipping_address_2` varchar(255)
,`shipping_city` varchar(100)
,`shipping_state` varchar(100)
,`shipping_postal_code` varchar(20)
,`shipping_country` varchar(100)
,`order_date` timestamp
,`shipped_date` timestamp
,`delivered_date` timestamp
,`created_at` timestamp
,`updated_at` timestamp
,`customer_name` varchar(255)
,`customer_email` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `compare_price` decimal(10,2) DEFAULT NULL,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `min_stock_level` int(11) DEFAULT 5,
  `weight` decimal(8,3) DEFAULT NULL,
  `dimensions` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `gallery` text DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_digital` tinyint(1) DEFAULT 0,
  `requires_shipping` tinyint(1) DEFAULT 1,
  `tax_status` enum('Taxable','Shipping only','None') DEFAULT 'Taxable',
  `tax_class` varchar(50) DEFAULT NULL,
  `status` enum('Active','Inactive','Draft','Out of Stock') DEFAULT 'Active',
  `visibility` enum('Visible','Hidden','Password Protected') DEFAULT 'Visible',
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `short_description`, `sku`, `barcode`, `category_id`, `brand_id`, `price`, `compare_price`, `cost_price`, `stock_quantity`, `min_stock_level`, `weight`, `dimensions`, `image_url`, `gallery`, `is_featured`, `is_digital`, `requires_shipping`, `tax_status`, `tax_class`, `status`, `visibility`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 'iPhone 15 Pro', 'Latest iPhone with A17 Pro chip, titanium design, and advanced camera system with 48MP main camera, 5x telephoto zoom, and ProRAW capabilities.', 'Latest iPhone with A17 Pro chip and titanium design', 'IP15P-256-TP', NULL, 1, 1, 999.00, 1099.00, NULL, 15, 5, 0.187, NULL, 'src/images/Iphone14Pro.jpeg', NULL, 1, 0, 1, 'Taxable', NULL, 'Active', 'Visible', NULL, NULL, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(2, 'MacBook Pro M3', 'Powerful laptop with M3 chip, stunning 14-inch Liquid Retina XDR display, and all-day battery life. Perfect for professionals and creators.', 'Powerful laptop with M3 chip and Retina display', 'MBP14-M3-512', NULL, 2, 1, 1599.00, NULL, NULL, 8, 5, 1.600, NULL, 'src/images/DellXPS13.jpeg', NULL, 1, 0, 1, 'Taxable', NULL, 'Active', 'Visible', NULL, NULL, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(3, 'AirPods Pro', 'Premium wireless earbuds with active noise cancellation, spatial audio, and adaptive transparency mode for the ultimate listening experience.', 'Premium wireless earbuds with noise cancellation', 'APP-2ND-GEN', NULL, 3, 1, 249.00, NULL, NULL, 3, 5, 0.050, NULL, 'src/images/SonyWH-1000XM5.jpeg', NULL, 0, 0, 1, 'Taxable', NULL, 'Active', 'Visible', NULL, NULL, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(4, 'Apple Watch Series 9', 'Advanced smartwatch with health monitoring, fitness tracking, cellular connectivity, and the new S9 SiP for improved performance.', 'Advanced smartwatch with health monitoring', 'AWS9-45-MID', NULL, 4, 1, 399.00, NULL, NULL, 12, 5, 0.040, NULL, 'src/images/AppleWatchSeries9.jpeg', NULL, 1, 0, 1, 'Taxable', NULL, 'Active', 'Visible', NULL, NULL, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(5, 'Samsung Galaxy S24', 'Latest Samsung flagship with AI features, improved camera system, long-lasting battery, and the powerful Snapdragon 8 Gen 3 processor.', 'Latest Samsung flagship with AI features', 'SGS24-256-BLK', NULL, 1, 2, 899.00, NULL, NULL, 20, 5, 0.170, NULL, 'src/images/placeholder-product.jpg', NULL, 1, 0, 1, 'Taxable', NULL, 'Active', 'Visible', NULL, NULL, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(6, 'Dell XPS 13', 'Ultra-portable laptop with stunning 13.4-inch InfinityEdge display, premium build quality, and exceptional performance in a compact design.', 'Ultra-portable laptop with InfinityEdge display', 'XPS13-I7-16GB', NULL, 2, 4, 1299.00, NULL, NULL, 5, 5, 1.200, NULL, 'src/images/DellXPS13.jpeg', NULL, 0, 0, 1, 'Taxable', NULL, 'Active', 'Visible', NULL, NULL, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(7, 'Sony WH-1000XM5', 'Industry-leading noise canceling headphones with exceptional sound quality, 30-hour battery life, and premium comfort for audiophiles.', 'Industry-leading noise canceling headphones', 'WH1000XM5-BLK', NULL, 3, 3, 399.99, NULL, NULL, 10, 5, 0.250, NULL, 'src/images/SonyWH-1000XM5.jpeg', NULL, 0, 0, 1, 'Taxable', NULL, 'Active', 'Visible', NULL, NULL, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(8, 'iPad Pro 12.9\"', 'Professional tablet with M2 chip, stunning 12.9-inch Liquid Retina XDR display, and Apple Pencil support for creative professionals.', 'Professional tablet with M2 chip and XDR display', 'IPP12-M2-256', NULL, 5, 1, 1099.00, NULL, NULL, 0, 5, 0.680, NULL, 'src/images/placeholder-product.jpg', NULL, 0, 0, 1, 'Taxable', NULL, 'Out of Stock', 'Visible', NULL, NULL, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(9, 'ramiru phone', 'very good', 'good', '32134325321765', NULL, NULL, NULL, 1000.00, 200.00, 50.00, 9, 5, 1.000, NULL, '/Assignment/uploads/products/img_68db71b3bff2d2.60510097.jpg', NULL, 1, 0, 1, 'Taxable', NULL, 'Active', 'Visible', NULL, NULL, '2025-09-30 05:59:15', '2025-09-30 05:59:15'),
(10, 'ramiru nonis', 'DBHAShgdsagdGDD', 'ewqgdhasGD', '321323234323232', NULL, NULL, NULL, 1000.00, 850.00, 50.00, 8, 5, 1000.000, NULL, '/Assignment/uploads/products/img_68dbb58ab189c0.87702110.jpg', NULL, 1, 0, 1, 'Taxable', NULL, 'Active', 'Visible', NULL, NULL, '2025-09-30 10:48:42', '2025-09-30 10:48:42');

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_name` varchar(100) NOT NULL,
  `attribute_value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `product_id`, `attribute_name`, `attribute_value`, `created_at`) VALUES
(1, 1, 'Color', 'Titanium Natural', '2025-09-30 04:42:08'),
(2, 1, 'Storage', '256GB', '2025-09-30 04:42:08'),
(3, 1, 'Display', '6.1-inch Super Retina XDR', '2025-09-30 04:42:08'),
(4, 1, 'Camera', '48MP Main + 12MP Ultra Wide + 12MP Telephoto', '2025-09-30 04:42:08'),
(5, 2, 'Processor', 'Apple M3', '2025-09-30 04:42:08'),
(6, 2, 'RAM', '16GB Unified Memory', '2025-09-30 04:42:08'),
(7, 2, 'Storage', '512GB SSD', '2025-09-30 04:42:08'),
(8, 2, 'Display', '14.2-inch Liquid Retina XDR', '2025-09-30 04:42:08'),
(9, 3, 'Battery Life', 'Up to 6 hours', '2025-09-30 04:42:08'),
(10, 3, 'Noise Cancellation', 'Active', '2025-09-30 04:42:08'),
(11, 3, 'Connectivity', 'Bluetooth 5.3', '2025-09-30 04:42:08'),
(12, 4, 'Case Size', '45mm', '2025-09-30 04:42:08'),
(13, 4, 'Display', 'Always-On Retina LTPO OLED', '2025-09-30 04:42:08'),
(14, 4, 'Health Features', 'ECG, Blood Oxygen, Heart Rate', '2025-09-30 04:42:08'),
(15, 5, 'Display', '6.2-inch Dynamic AMOLED 2X', '2025-09-30 04:42:08'),
(16, 5, 'Processor', 'Snapdragon 8 Gen 3', '2025-09-30 04:42:08'),
(17, 5, 'Camera', '50MP Triple Camera System', '2025-09-30 04:42:08');

-- --------------------------------------------------------

--
-- Stand-in structure for view `product_details`
-- (See below for the actual view)
--
CREATE TABLE `product_details` (
`id` int(11)
,`name` varchar(255)
,`description` text
,`short_description` varchar(500)
,`sku` varchar(100)
,`barcode` varchar(100)
,`category_id` int(11)
,`brand_id` int(11)
,`price` decimal(10,2)
,`compare_price` decimal(10,2)
,`cost_price` decimal(10,2)
,`stock_quantity` int(11)
,`min_stock_level` int(11)
,`weight` decimal(8,3)
,`dimensions` varchar(100)
,`image_url` varchar(255)
,`gallery` text
,`is_featured` tinyint(1)
,`is_digital` tinyint(1)
,`requires_shipping` tinyint(1)
,`tax_status` enum('Taxable','Shipping only','None')
,`tax_class` varchar(50)
,`status` enum('Active','Inactive','Draft','Out of Stock')
,`visibility` enum('Visible','Hidden','Password Protected')
,`meta_title` varchar(255)
,`meta_description` text
,`created_at` timestamp
,`updated_at` timestamp
,`category_name` varchar(255)
,`brand_name` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `title` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `is_verified_purchase` tinyint(1) DEFAULT 0,
  `is_approved` tinyint(1) DEFAULT 0,
  `helpful_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `title`, `comment`, `is_verified_purchase`, `is_approved`, `helpful_count`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 5, 'Amazing phone!', 'The iPhone 15 Pro is incredible. The camera quality is outstanding and the titanium build feels premium.', 1, 1, 0, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(2, 2, 3, 4, 'Great laptop for work', 'The MacBook Pro M3 handles all my development work smoothly. Battery life is excellent.', 1, 1, 0, '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(3, 3, 4, 5, 'Best earbuds ever', 'The noise cancellation on these AirPods Pro is mind-blowing. Perfect for commuting.', 1, 1, 0, '2025-09-30 04:42:08', '2025-09-30 04:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` enum('text','number','boolean','json') DEFAULT 'text',
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Cellario', 'text', 'Website name', '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(2, 'site_description', 'Your Electronics Store', 'text', 'Website description', '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(3, 'currency', 'USD', 'text', 'Default currency', '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(4, 'tax_rate', '8.00', 'number', 'Default tax rate percentage', '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(5, 'free_shipping_minimum', '100.00', 'number', 'Minimum order for free shipping', '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(6, 'email_notifications', 'true', 'boolean', 'Enable email notifications', '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(7, 'maintenance_mode', 'false', 'boolean', 'Enable maintenance mode', '2025-09-30 04:42:08', '2025-09-30 04:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('Admin','Customer') NOT NULL DEFAULT 'Customer',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT 'USA',
  `profile_image` varchar(255) DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `status` enum('Active','Inactive','Suspended') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `password`, `phone`, `address`, `city`, `state`, `postal_code`, `country`, `profile_image`, `email_verified`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Admin User', 'admin@cellario.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1234567890', NULL, NULL, NULL, NULL, 'USA', NULL, 0, 'Active', '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(2, 'Customer', 'John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1234567890', '123 Main St', 'New York', 'NY', '10001', 'USA', NULL, 0, 'Active', '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(3, 'Customer', 'Jane Smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0987654321', '456 Oak Ave', 'Los Angeles', 'CA', '90001', 'USA', NULL, 0, 'Active', '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(4, 'Customer', 'Mike Johnson', 'mike@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '5555551234', '789 Pine Rd', 'Chicago', 'IL', '60601', 'USA', NULL, 0, 'Active', '2025-09-30 04:42:08', '2025-09-30 04:42:08'),
(5, 'Admin', 'ramiru nonis', 'admin@example.com', '$2y$10$UA/25hb0AtgdIHwg4ZlrYezO.tWcuI32ai249cfcWpWTuojRBWj6y', '', NULL, NULL, NULL, NULL, 'USA', NULL, 0, 'Active', '2025-09-30 05:12:36', '2025-09-30 10:44:26'),
(6, 'Customer', 'ramiru nonis', 'ramiru@example.com', '$2y$10$qA7fsKzqY900rGSYAZZvvOCIEYlCCkBFZkn0WriAp8sa9UAOzLY/q', '', NULL, NULL, NULL, NULL, 'USA', NULL, 0, 'Active', '2025-09-30 06:04:23', '2025-09-30 10:56:25'),
(7, 'Admin', 'Ramiru nonis', 'ramirunonis2006@gmail.com', '$2y$10$JL2w1Hl.hgAMnYZ/NuWcZ.W3FUnwPz.9IRzjM4aab7IWFv/e7s4Xy', '', NULL, NULL, NULL, NULL, 'USA', NULL, 0, 'Active', '2026-01-10 21:16:50', '2026-01-10 21:35:21');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure for view `low_stock_products`
--
DROP TABLE IF EXISTS `low_stock_products`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `low_stock_products`  AS SELECT `p`.`id` AS `id`, `p`.`name` AS `name`, `p`.`description` AS `description`, `p`.`short_description` AS `short_description`, `p`.`sku` AS `sku`, `p`.`barcode` AS `barcode`, `p`.`category_id` AS `category_id`, `p`.`brand_id` AS `brand_id`, `p`.`price` AS `price`, `p`.`compare_price` AS `compare_price`, `p`.`cost_price` AS `cost_price`, `p`.`stock_quantity` AS `stock_quantity`, `p`.`min_stock_level` AS `min_stock_level`, `p`.`weight` AS `weight`, `p`.`dimensions` AS `dimensions`, `p`.`image_url` AS `image_url`, `p`.`gallery` AS `gallery`, `p`.`is_featured` AS `is_featured`, `p`.`is_digital` AS `is_digital`, `p`.`requires_shipping` AS `requires_shipping`, `p`.`tax_status` AS `tax_status`, `p`.`tax_class` AS `tax_class`, `p`.`status` AS `status`, `p`.`visibility` AS `visibility`, `p`.`meta_title` AS `meta_title`, `p`.`meta_description` AS `meta_description`, `p`.`created_at` AS `created_at`, `p`.`updated_at` AS `updated_at`, `c`.`name` AS `category_name`, `b`.`name` AS `brand_name` FROM ((`products` `p` left join `categories` `c` on(`p`.`category_id` = `c`.`id`)) left join `brands` `b` on(`p`.`brand_id` = `b`.`id`)) WHERE `p`.`stock_quantity` <= `p`.`min_stock_level` AND `p`.`status` = 'Active' ;

-- --------------------------------------------------------

--
-- Structure for view `order_summary`
--
DROP TABLE IF EXISTS `order_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `order_summary`  AS SELECT `o`.`id` AS `id`, `o`.`order_number` AS `order_number`, `o`.`user_id` AS `user_id`, `o`.`status` AS `status`, `o`.`currency` AS `currency`, `o`.`subtotal` AS `subtotal`, `o`.`tax_amount` AS `tax_amount`, `o`.`shipping_amount` AS `shipping_amount`, `o`.`discount_amount` AS `discount_amount`, `o`.`total_amount` AS `total_amount`, `o`.`payment_method` AS `payment_method`, `o`.`payment_status` AS `payment_status`, `o`.`shipping_method` AS `shipping_method`, `o`.`tracking_number` AS `tracking_number`, `o`.`notes` AS `notes`, `o`.`billing_first_name` AS `billing_first_name`, `o`.`billing_last_name` AS `billing_last_name`, `o`.`billing_company` AS `billing_company`, `o`.`billing_address_1` AS `billing_address_1`, `o`.`billing_address_2` AS `billing_address_2`, `o`.`billing_city` AS `billing_city`, `o`.`billing_state` AS `billing_state`, `o`.`billing_postal_code` AS `billing_postal_code`, `o`.`billing_country` AS `billing_country`, `o`.`billing_email` AS `billing_email`, `o`.`billing_phone` AS `billing_phone`, `o`.`shipping_first_name` AS `shipping_first_name`, `o`.`shipping_last_name` AS `shipping_last_name`, `o`.`shipping_company` AS `shipping_company`, `o`.`shipping_address_1` AS `shipping_address_1`, `o`.`shipping_address_2` AS `shipping_address_2`, `o`.`shipping_city` AS `shipping_city`, `o`.`shipping_state` AS `shipping_state`, `o`.`shipping_postal_code` AS `shipping_postal_code`, `o`.`shipping_country` AS `shipping_country`, `o`.`order_date` AS `order_date`, `o`.`shipped_date` AS `shipped_date`, `o`.`delivered_date` AS `delivered_date`, `o`.`created_at` AS `created_at`, `o`.`updated_at` AS `updated_at`, `u`.`name` AS `customer_name`, `u`.`email` AS `customer_email` FROM (`orders` `o` left join `users` `u` on(`o`.`user_id` = `u`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `product_details`
--
DROP TABLE IF EXISTS `product_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `product_details`  AS SELECT `p`.`id` AS `id`, `p`.`name` AS `name`, `p`.`description` AS `description`, `p`.`short_description` AS `short_description`, `p`.`sku` AS `sku`, `p`.`barcode` AS `barcode`, `p`.`category_id` AS `category_id`, `p`.`brand_id` AS `brand_id`, `p`.`price` AS `price`, `p`.`compare_price` AS `compare_price`, `p`.`cost_price` AS `cost_price`, `p`.`stock_quantity` AS `stock_quantity`, `p`.`min_stock_level` AS `min_stock_level`, `p`.`weight` AS `weight`, `p`.`dimensions` AS `dimensions`, `p`.`image_url` AS `image_url`, `p`.`gallery` AS `gallery`, `p`.`is_featured` AS `is_featured`, `p`.`is_digital` AS `is_digital`, `p`.`requires_shipping` AS `requires_shipping`, `p`.`tax_status` AS `tax_status`, `p`.`tax_class` AS `tax_class`, `p`.`status` AS `status`, `p`.`visibility` AS `visibility`, `p`.`meta_title` AS `meta_title`, `p`.`meta_description` AS `meta_description`, `p`.`created_at` AS `created_at`, `p`.`updated_at` AS `updated_at`, `c`.`name` AS `category_name`, `b`.`name` AS `brand_name` FROM ((`products` `p` left join `categories` `c` on(`p`.`category_id` = `c`.`id`)) left join `brands` `b` on(`p`.`brand_id` = `b`.`id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_session` (`session_id`),
  ADD KEY `idx_product` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_code` (`code`),
  ADD KEY `idx_active` (`is_active`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_order_date` (`order_date`),
  ADD KEY `idx_orders_total` (`total_amount`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order` (`order_id`),
  ADD KEY `idx_product` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `idx_token` (`token`),
  ADD KEY `idx_expires` (`expires_at`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_brand` (`brand_id`),
  ADD KEY `idx_sku` (`sku`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_featured` (`is_featured`),
  ADD KEY `idx_products_price` (`price`),
  ADD KEY `idx_products_created` (`created_at`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_attribute` (`product_id`,`attribute_name`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_rating` (`rating`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`),
  ADD KEY `idx_key` (`setting_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_email` (`email`),
  ADD KEY `idx_users_role` (`role`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`user_id`,`product_id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_product` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD CONSTRAINT `password_reset_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `product_attributes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
