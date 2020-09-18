-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 12, 2020 at 03:04 PM
-- Server version: 10.2.33-MariaDB-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lucidcom_tgg`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `billing_address` tinyint(1) DEFAULT NULL,
  `line1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `customer_id`, `billing_address`, `line1`, `line2`, `city`, `state`, `postcode`, `country`, `created_at`, `updated_at`) VALUES
(1, 3, NULL, '1 Main St', NULL, 'Town', 'ACT', '3330', 'Australia', '2020-08-31 03:48:41', '2020-08-31 03:48:41'),
(2, 9, NULL, '1 Main St', NULL, 'Melton South', 'Vic', '3338', 'Australia', '2020-09-01 03:29:16', '2020-09-01 03:29:16'),
(3, 10, NULL, '1 Main St', NULL, 'Melton South', 'Vic', '3338', 'Australia', '2020-09-03 02:29:58', '2020-09-03 02:29:58'),
(4, 11, NULL, '10 Main St', NULL, 'Mytown', 'NSW', '2000', 'Australia', '2020-09-05 04:34:41', '2020-09-05 04:34:41'),
(5, 12, NULL, '46 Rees Road', NULL, 'Melton South', 'Vic', '3338', 'Australia', '2020-09-06 23:27:53', '2020-09-06 23:27:53'),
(6, 13, NULL, '1 Main St', NULL, 'Melton South', 'Vic', '3338', 'Australia', '2020-09-07 00:00:52', '2020-09-07 00:00:52'),
(7, 14, NULL, '1 Main St', NULL, 'Melton South', 'Vic', '3338', 'Australia', '2020-09-07 00:41:20', '2020-09-07 00:41:20'),
(8, 15, NULL, '1 Main St', NULL, 'Melton South', 'Vic', '3338', 'Australia', '2020-09-07 01:30:07', '2020-09-07 01:30:07'),
(9, 20, NULL, '361 Stumpy Gully Rd', NULL, 'Balnarring', 'Vic', '3926', 'Australia', '2020-09-07 14:48:31', '2020-09-07 14:48:31'),
(10, 21, NULL, '1 Main St', NULL, 'Melton South', 'ACT', '3338', 'Australia', '2020-09-07 18:09:15', '2020-09-07 18:09:15'),
(11, 22, NULL, '361 Stumpy Gully Rd', NULL, 'Balnarring', 'Vic', '3926', 'Australia', '2020-09-07 19:35:08', '2020-09-07 19:35:08'),
(12, 22, NULL, '361 Stumpy Gully Rd', NULL, 'Balnarring', 'Vic', '3926', 'Australia', '2020-09-07 19:37:57', '2020-09-07 19:37:57'),
(13, 24, NULL, '1 Main St', NULL, 'Melton South', 'Vic', '3338', 'Australia', '2020-09-07 20:40:07', '2020-09-07 20:40:07'),
(14, 24, NULL, '1 Main St', NULL, 'Melton South', 'ACT', '3', 'Australia', '2020-09-07 21:11:26', '2020-09-07 21:11:26'),
(15, 24, NULL, '1 Main St', NULL, 'Melton South', 'ACT', '3', 'Australia', '2020-09-07 21:13:40', '2020-09-07 21:13:40'),
(16, 24, NULL, '1 Main St', NULL, 'Melton South', 'ACT', '7000', 'Australia', '2020-09-07 21:14:11', '2020-09-07 21:14:11');

-- --------------------------------------------------------

--
-- Table structure for table `bundles`
--

CREATE TABLE `bundles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bundles`
--

INSERT INTO `bundles` (`id`, `product_id`, `title`, `slug`, `image`, `description`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 'Homestead Pack', 'homestead-pack', NULL, '5 Paulownia Headstarters™', 67, NULL, NULL),
(2, 1, 'Farm Pack', 'farm-pack', NULL, '10 Paulownia Headstarters™', 100, NULL, NULL),
(3, 1, 'Estate Pack', 'estate-pack', NULL, '25 Paulownia Headstarters™ ', 229, NULL, NULL),
(4, 1, 'Grove Pack', 'grove-pack', NULL, '50 Paulownia Headstarters™ ', 417, NULL, NULL),
(5, 1, 'Woodland Pack', 'woodland-pack', NULL, '100 Paulownia Headstarters™', 667, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `order`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Category 1', 'category-1', '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(2, NULL, 1, 'Category 2', 'category-2', '2020-09-01 08:07:51', '2020-09-01 08:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Test Sender', 'test@example.com', NULL, 'My subject', 'Test message', '2020-09-04 03:24:50', '2020-09-04 03:24:50'),
(2, 'Test Sender', 'test@example.com', NULL, 'My subject', 'Test message', '2020-09-04 03:25:38', '2020-09-04 03:25:38'),
(3, 'Test Sender', 'test@lucid.com.au', NULL, 'test subject', 'My message', '2020-09-04 03:26:55', '2020-09-04 03:26:55'),
(4, 'Test Sender', 'test@example.com', NULL, 'test subject', 'my test message', '2020-09-04 04:00:26', '2020-09-04 04:00:26'),
(5, 'Test Sender', 'test@example.com', NULL, 'test subject', 'My test message', '2020-09-04 04:05:15', '2020-09-04 04:05:15'),
(6, 'Test Sender', 'test@lucid.com.au', NULL, 'My subject', 'message', '2020-09-06 19:22:26', '2020-09-06 19:22:26');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `name`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Test Sender', 'test@example.com', '0', '2020-08-31 02:24:02', '2020-08-31 02:24:02'),
(2, NULL, 'Test Sender', 'test@example.com', '1', '2020-08-31 02:28:12', '2020-08-31 02:28:12'),
(3, NULL, 'Test Sender', 'test@example.com', '1', '2020-08-31 02:28:51', '2020-08-31 02:28:51'),
(4, NULL, 'Test Sender', 'test@example.com', '2', '2020-08-31 02:30:30', '2020-08-31 02:30:30'),
(5, NULL, 'Ima Test', 'trace@example.com', '12345', '2020-08-31 03:36:18', '2020-08-31 03:36:18'),
(6, NULL, 'Test Sender', 'test@example.com', '0444 444 444', '2020-09-01 03:12:36', '2020-09-01 03:12:36'),
(7, NULL, 'Test Sender', 'test@example.com', '0444 444 444', '2020-09-01 03:13:17', '2020-09-01 03:13:17'),
(8, NULL, 'Test Sender', 'test@example.com', '0444 444 444', '2020-09-01 03:14:17', '2020-09-01 03:14:17'),
(9, NULL, 'Test Sender', 'test@example.com', '0444 444 444', '2020-09-01 03:15:11', '2020-09-01 03:15:11'),
(10, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-03 02:29:21', '2020-09-03 02:29:21'),
(11, NULL, 'Ima Test', 'trace@example.com', '03 7010 1232', '2020-09-05 04:34:14', '2020-09-05 04:34:14'),
(12, NULL, 'Joe', 'joe@example.com', '03 7010 1219', '2020-09-06 23:27:30', '2020-09-06 23:27:30'),
(13, NULL, 'Joe Doe', 'test@example.com', '03 7010 1234', '2020-09-07 00:00:27', '2020-09-07 00:00:27'),
(14, NULL, 'Test Sender', 'test@example.com', '03 7010 1234', '2020-09-07 00:40:59', '2020-09-07 00:40:59'),
(15, NULL, 'Joe Doe', 'test@example.com', '03 7010 1234', '2020-09-07 01:29:25', '2020-09-07 01:29:25'),
(16, NULL, 'James Lawrence', 'james@toadgully.com.au', '2781636', '2020-09-06 23:47:15', '2020-09-06 23:47:15'),
(17, NULL, 'James Lawrence', 'james@toadgully.com.au', '0359835688', '2020-09-06 23:47:49', '2020-09-06 23:47:49'),
(18, NULL, 'James Lawrence', 'james@notreal', '0359835688', '2020-09-06 23:48:04', '2020-09-06 23:48:04'),
(19, NULL, 'James Lawrence', 'james@toadgully.com.au', '0359835688', '2020-09-06 23:50:22', '2020-09-06 23:50:22'),
(20, NULL, 'James Lawrence', 'james@toadgully.com.au', '0359835688', '2020-09-07 14:41:06', '2020-09-07 14:41:06'),
(21, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-07 18:08:42', '2020-09-07 18:08:42'),
(22, NULL, 'James', 'james@toadgully.com.au', '0359835688', '2020-09-07 19:34:38', '2020-09-07 19:34:38'),
(23, NULL, 'Joe Doe', 'joe@example.com', '0370101219', '2020-09-07 20:37:22', '2020-09-07 20:37:22'),
(24, NULL, 'Test Sender', 'test@example.com', '03 7010 1234', '2020-09-07 20:38:00', '2020-09-07 20:38:00'),
(25, NULL, 'Test Sender', 'test@example.com', '01 7010 1234', '2020-09-07 22:09:33', '2020-09-07 22:09:33');

-- --------------------------------------------------------

--
-- Table structure for table `data_rows`
--

CREATE TABLE `data_rows` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_type_id` int(10) UNSIGNED NOT NULL,
  `field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `browse` tinyint(1) NOT NULL DEFAULT 1,
  `read` tinyint(1) NOT NULL DEFAULT 1,
  `edit` tinyint(1) NOT NULL DEFAULT 1,
  `add` tinyint(1) NOT NULL DEFAULT 1,
  `delete` tinyint(1) NOT NULL DEFAULT 1,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_rows`
--

INSERT INTO `data_rows` (`id`, `data_type_id`, `field`, `type`, `display_name`, `required`, `browse`, `read`, `edit`, `add`, `delete`, `details`, `order`) VALUES
(1, 1, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(2, 1, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(3, 1, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, NULL, 3),
(4, 1, 'password', 'password', 'Password', 1, 0, 0, 1, 1, 0, NULL, 4),
(5, 1, 'remember_token', 'text', 'Remember Token', 0, 0, 0, 0, 0, 0, NULL, 5),
(6, 1, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, NULL, 6),
(7, 1, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
(8, 1, 'avatar', 'image', 'Avatar', 0, 1, 1, 1, 1, 1, NULL, 8),
(9, 1, 'user_belongsto_role_relationship', 'relationship', 'Role', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"roles\",\"pivot\":0}', 10),
(10, 1, 'user_belongstomany_role_relationship', 'relationship', 'Roles', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"user_roles\",\"pivot\":\"1\",\"taggable\":\"0\"}', 11),
(11, 1, 'settings', 'hidden', 'Settings', 0, 0, 0, 0, 0, 0, NULL, 12),
(12, 2, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(13, 2, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(14, 2, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 3),
(15, 2, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(16, 3, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(17, 3, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(18, 3, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 3),
(19, 3, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(20, 3, 'display_name', 'text', 'Display Name', 1, 1, 1, 1, 1, 1, NULL, 5),
(21, 1, 'role_id', 'text', 'Role', 1, 1, 1, 1, 1, 1, NULL, 9),
(22, 4, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(23, 4, 'parent_id', 'select_dropdown', 'Parent', 0, 0, 1, 1, 1, 1, '{\"default\":\"\",\"null\":\"\",\"options\":{\"\":\"-- None --\"},\"relationship\":{\"key\":\"id\",\"label\":\"name\"}}', 2),
(24, 4, 'order', 'text', 'Order', 1, 1, 1, 1, 1, 1, '{\"default\":1}', 3),
(25, 4, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 4),
(26, 4, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\"}}', 5),
(27, 4, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 0, NULL, 6),
(28, 4, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
(29, 5, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(30, 5, 'author_id', 'text', 'Author', 1, 0, 1, 1, 0, 1, NULL, 2),
(31, 5, 'category_id', 'text', 'Category', 1, 0, 1, 1, 1, 0, NULL, 3),
(32, 5, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, NULL, 4),
(33, 5, 'excerpt', 'text_area', 'Excerpt', 1, 0, 1, 1, 1, 1, NULL, 5),
(34, 5, 'body', 'rich_text_box', 'Body', 1, 0, 1, 1, 1, 1, NULL, 6),
(35, 5, 'image', 'image', 'Post Image', 0, 1, 1, 1, 1, 1, '{\"resize\":{\"width\":\"1000\",\"height\":\"null\"},\"quality\":\"70%\",\"upsize\":true,\"thumbnails\":[{\"name\":\"medium\",\"scale\":\"50%\"},{\"name\":\"small\",\"scale\":\"25%\"},{\"name\":\"cropped\",\"crop\":{\"width\":\"300\",\"height\":\"250\"}}]}', 7),
(36, 5, 'slug', 'text', 'Slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\",\"forceUpdate\":true},\"validation\":{\"rule\":\"unique:posts,slug\"}}', 8),
(37, 5, 'meta_description', 'text_area', 'Meta Description', 1, 0, 1, 1, 1, 1, NULL, 9),
(38, 5, 'meta_keywords', 'text_area', 'Meta Keywords', 1, 0, 1, 1, 1, 1, NULL, 10),
(39, 5, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"DRAFT\",\"options\":{\"PUBLISHED\":\"published\",\"DRAFT\":\"draft\",\"PENDING\":\"pending\"}}', 11),
(40, 5, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, NULL, 12),
(41, 5, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 13),
(42, 5, 'seo_title', 'text', 'SEO Title', 0, 1, 1, 1, 1, 1, NULL, 14),
(43, 5, 'featured', 'checkbox', 'Featured', 1, 1, 1, 1, 1, 1, NULL, 15),
(44, 6, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(45, 6, 'author_id', 'text', 'Author', 1, 0, 0, 0, 0, 0, NULL, 2),
(46, 6, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, NULL, 3),
(47, 6, 'excerpt', 'text_area', 'Excerpt', 1, 0, 1, 1, 1, 1, NULL, 4),
(48, 6, 'body', 'rich_text_box', 'Body', 1, 0, 1, 1, 1, 1, NULL, 5),
(49, 6, 'slug', 'text', 'Slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\"},\"validation\":{\"rule\":\"unique:pages,slug\"}}', 6),
(50, 6, 'meta_description', 'text', 'Meta Description', 1, 0, 1, 1, 1, 1, NULL, 7),
(51, 6, 'meta_keywords', 'text', 'Meta Keywords', 1, 0, 1, 1, 1, 1, NULL, 8),
(52, 6, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"INACTIVE\",\"options\":{\"INACTIVE\":\"INACTIVE\",\"ACTIVE\":\"ACTIVE\"}}', 9),
(53, 6, 'created_at', 'timestamp', 'Created At', 1, 1, 1, 0, 0, 0, NULL, 10),
(54, 6, 'updated_at', 'timestamp', 'Updated At', 1, 0, 0, 0, 0, 0, NULL, 11),
(55, 6, 'image', 'image', 'Page Image', 0, 1, 1, 1, 1, 1, NULL, 12),
(56, 7, 'id', 'hidden', 'Id', 1, 1, 1, 1, 1, 0, '{}', 1),
(57, 7, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 2),
(58, 7, 'botanical_name', 'text', 'Botanical Name', 1, 1, 1, 1, 1, 1, '{}', 3),
(59, 7, 'image', 'image', 'Image', 0, 1, 1, 1, 1, 1, '{}', 4),
(60, 7, 'description', 'text', 'Description', 0, 1, 1, 1, 1, 1, '{}', 5),
(61, 7, 'published', 'checkbox', 'Published', 0, 1, 1, 1, 1, 1, '{}', 6),
(62, 7, 'promoted', 'checkbox', 'Promoted', 0, 1, 1, 1, 1, 1, '{}', 7),
(63, 7, 'plantcategory_id', 'text', 'Plantcategory Id', 0, 1, 1, 1, 1, 1, '{}', 8),
(64, 7, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, '{}', 9),
(65, 7, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 10),
(66, 8, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(67, 8, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 2),
(68, 8, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{}', 3),
(69, 8, 'description', 'text', 'Description', 0, 1, 1, 1, 1, 1, '{}', 4),
(70, 8, 'published', 'text', 'Published', 0, 1, 1, 1, 1, 1, '{}', 5),
(71, 8, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 6),
(72, 8, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 7),
(73, 7, 'plant_belongsto_plantcategory_relationship', 'relationship', 'plantcategories', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\PlantCategory\",\"table\":\"plantcategories\",\"type\":\"belongsTo\",\"column\":\"plantcategory_id\",\"key\":\"id\",\"label\":\"title\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 11),
(74, 9, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(75, 9, 'customer_id', 'text', 'Customer Id', 0, 1, 1, 1, 1, 1, '{}', 2),
(76, 9, 'user_id', 'text', 'User Id', 0, 1, 1, 1, 1, 1, '{}', 3),
(77, 9, 'order_status_id', 'text', 'Order Status Id', 0, 1, 1, 1, 1, 1, '{}', 4),
(78, 9, 'address_id', 'text', 'Address Id', 0, 1, 1, 1, 1, 1, '{}', 5),
(79, 9, 'email', 'text', 'Email', 0, 1, 1, 1, 1, 1, '{}', 6),
(80, 9, 'name', 'text', 'Name', 0, 1, 1, 1, 1, 1, '{}', 7),
(81, 9, 'address', 'text', 'Address', 0, 1, 1, 1, 1, 1, '{}', 8),
(82, 9, 'city', 'text', 'City', 0, 1, 1, 1, 1, 1, '{}', 9),
(83, 9, 'state', 'text', 'State', 0, 1, 1, 1, 1, 1, '{}', 10),
(84, 9, 'postcode', 'text', 'Postcode', 0, 1, 1, 1, 1, 1, '{}', 11),
(85, 9, 'phone', 'text', 'Phone', 0, 1, 1, 1, 1, 1, '{}', 12),
(86, 9, 'cart', 'text', 'Cart', 0, 1, 1, 1, 1, 1, '{}', 13),
(87, 9, 'comments', 'text', 'Comments', 0, 1, 1, 1, 1, 1, '{}', 14),
(88, 9, 'tax', 'text', 'Tax', 0, 1, 1, 1, 1, 1, '{}', 15),
(89, 9, 'total', 'text', 'Total', 0, 1, 1, 1, 1, 1, '{}', 16),
(90, 9, 'description', 'text', 'Description', 0, 1, 1, 1, 1, 1, '{}', 17),
(91, 9, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 18),
(92, 9, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 19),
(93, 10, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(94, 10, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 2),
(95, 10, 'body', 'text', 'Body', 0, 1, 1, 1, 1, 1, '{}', 3),
(96, 10, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, '{}', 4),
(97, 10, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 5),
(98, 9, 'order_hasone_order_status_relationship', 'relationship', 'order_statuses', 0, 1, 1, 1, 1, 1, '{\"model\":\"\\\\App\\\\OrderStatus\",\"table\":\"order_statuses\",\"type\":\"hasOne\",\"column\":\"id\",\"key\":\"id\",\"label\":\"title\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 20),
(99, 11, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(100, 11, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 2),
(101, 11, 'code', 'text', 'Code', 0, 1, 1, 1, 1, 1, '{}', 3),
(102, 11, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{}', 4),
(103, 11, 'image', 'file', 'Image', 0, 1, 1, 1, 1, 1, '{}', 5),
(104, 11, 'description', 'rich_text_box', 'Description', 0, 1, 1, 1, 1, 1, '{}', 6),
(105, 11, 'published', 'checkbox', 'Published', 0, 1, 1, 1, 1, 1, '{}', 7),
(106, 11, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 8),
(107, 11, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 9),
(108, 11, 'product_hasmany_bundle_relationship', 'relationship', 'bundles', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Bundle\",\"table\":\"bundles\",\"type\":\"hasMany\",\"column\":\"product_id\",\"key\":\"id\",\"label\":\"title\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 10),
(109, 12, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(110, 12, 'product_id', 'text', 'Product Id', 1, 1, 1, 1, 1, 1, '{}', 2),
(111, 12, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 3),
(112, 12, 'slug', 'text', 'Slug', 0, 1, 1, 1, 1, 1, '{}', 4),
(113, 12, 'image', 'text', 'Image', 0, 1, 1, 1, 1, 1, '{}', 5),
(114, 12, 'description', 'text', 'Description', 0, 1, 1, 1, 1, 1, '{}', 6),
(115, 12, 'price', 'text', 'Price', 1, 1, 1, 1, 1, 1, '{}', 7),
(116, 12, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 8),
(117, 12, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 9),
(118, 12, 'bundle_belongsto_product_relationship', 'relationship', 'products', 0, 1, 1, 1, 1, 1, '{\"model\":\"\\\\App\\\\Product\",\"table\":\"products\",\"type\":\"belongsTo\",\"column\":\"product_id\",\"key\":\"id\",\"label\":\"title\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":null}', 10);

-- --------------------------------------------------------

--
-- Table structure for table `data_types`
--

CREATE TABLE `data_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT 0,
  `server_side` tinyint(4) NOT NULL DEFAULT 0,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_types`
--

INSERT INTO `data_types` (`id`, `name`, `slug`, `display_name_singular`, `display_name_plural`, `icon`, `model_name`, `policy_name`, `controller`, `description`, `generate_permissions`, `server_side`, `details`, `created_at`, `updated_at`) VALUES
(1, 'users', 'users', 'User', 'Users', 'voyager-person', 'TCG\\Voyager\\Models\\User', 'TCG\\Voyager\\Policies\\UserPolicy', 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController', '', 1, 0, NULL, '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(2, 'menus', 'menus', 'Menu', 'Menus', 'voyager-list', 'TCG\\Voyager\\Models\\Menu', NULL, '', '', 1, 0, NULL, '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(3, 'roles', 'roles', 'Role', 'Roles', 'voyager-lock', 'TCG\\Voyager\\Models\\Role', NULL, 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController', '', 1, 0, NULL, '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(4, 'categories', 'categories', 'Category', 'Categories', 'voyager-categories', 'TCG\\Voyager\\Models\\Category', NULL, '', '', 1, 0, NULL, '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(5, 'posts', 'posts', 'Post', 'Posts', 'voyager-news', 'TCG\\Voyager\\Models\\Post', 'TCG\\Voyager\\Policies\\PostPolicy', '', '', 1, 0, NULL, '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(6, 'pages', 'pages', 'Page', 'Pages', 'voyager-file-text', 'TCG\\Voyager\\Models\\Page', NULL, '', '', 1, 0, NULL, '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(7, 'plants', 'plants', 'Plant', 'Plants', 'voyager-leaf', 'App\\Plant', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2020-09-01 08:14:33', '2020-09-01 14:11:35'),
(8, 'plantcategories', 'plantcategories', 'Plantcategory', 'Plantcategories', NULL, 'App\\Plantcategory', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2020-09-01 08:27:13', '2020-09-01 08:27:13'),
(9, 'orders', 'orders', 'Order', 'Orders', 'voyager-credit-cards', 'App\\Order', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2020-09-03 03:55:35', '2020-09-03 04:01:06'),
(10, 'order_statuses', 'order-statuses', 'Order Status', 'Order Statuses', NULL, 'App\\OrderStatus', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2020-09-03 03:57:22', '2020-09-03 03:57:22'),
(11, 'products', 'products', 'Product', 'Products', 'voyager-truck', 'App\\Product', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2020-09-04 01:06:33', '2020-09-04 01:27:52'),
(12, 'bundles', 'bundles', 'Bundle', 'Bundles', 'voyager-list-add', 'App\\Bundle', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2020-09-04 01:19:59', '2020-09-04 01:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(2, 'Main Menu', '2020-09-01 08:34:07', '2020-09-01 08:34:07');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `url`, `target`, `icon_class`, `color`, `parent_id`, `order`, `created_at`, `updated_at`, `route`, `parameters`) VALUES
(1, 1, 'Dashboard', '', '_self', 'voyager-boat', NULL, NULL, 1, '2020-09-01 08:03:52', '2020-09-01 08:03:52', 'voyager.dashboard', NULL),
(2, 1, 'Media', '', '_self', 'voyager-images', NULL, NULL, 5, '2020-09-01 08:03:52', '2020-09-01 08:03:52', 'voyager.media.index', NULL),
(3, 1, 'Users', '', '_self', 'voyager-person', NULL, NULL, 3, '2020-09-01 08:03:52', '2020-09-01 08:03:52', 'voyager.users.index', NULL),
(4, 1, 'Roles', '', '_self', 'voyager-lock', NULL, NULL, 2, '2020-09-01 08:03:52', '2020-09-01 08:03:52', 'voyager.roles.index', NULL),
(5, 1, 'Tools', '', '_self', 'voyager-tools', NULL, NULL, 9, '2020-09-01 08:03:52', '2020-09-01 08:03:52', NULL, NULL),
(6, 1, 'Menu Builder', '', '_self', 'voyager-list', NULL, 5, 10, '2020-09-01 08:03:52', '2020-09-01 08:03:52', 'voyager.menus.index', NULL),
(7, 1, 'Database', '', '_self', 'voyager-data', NULL, 5, 11, '2020-09-01 08:03:52', '2020-09-01 08:03:52', 'voyager.database.index', NULL),
(8, 1, 'Compass', '', '_self', 'voyager-compass', NULL, 5, 12, '2020-09-01 08:03:52', '2020-09-01 08:03:52', 'voyager.compass.index', NULL),
(9, 1, 'BREAD', '', '_self', 'voyager-bread', NULL, 5, 13, '2020-09-01 08:03:52', '2020-09-01 08:03:52', 'voyager.bread.index', NULL),
(10, 1, 'Settings', '', '_self', 'voyager-settings', NULL, NULL, 14, '2020-09-01 08:03:52', '2020-09-01 08:03:52', 'voyager.settings.index', NULL),
(11, 1, 'Categories', '', '_self', 'voyager-categories', NULL, NULL, 8, '2020-09-01 08:07:51', '2020-09-01 08:07:51', 'voyager.categories.index', NULL),
(12, 1, 'Posts', '', '_self', 'voyager-news', NULL, NULL, 6, '2020-09-01 08:07:51', '2020-09-01 08:07:51', 'voyager.posts.index', NULL),
(13, 1, 'Pages', '', '_self', 'voyager-file-text', NULL, NULL, 7, '2020-09-01 08:07:52', '2020-09-01 08:07:52', 'voyager.pages.index', NULL),
(14, 1, 'Hooks', '', '_self', 'voyager-hook', NULL, 5, 13, '2020-09-01 08:07:52', '2020-09-01 08:07:52', 'voyager.hooks', NULL),
(15, 1, 'Plants', '', '_self', 'voyager-leaf', NULL, NULL, 15, '2020-09-01 08:14:33', '2020-09-01 08:14:33', 'voyager.plants.index', NULL),
(16, 1, 'Plantcategories', '', '_self', NULL, NULL, NULL, 16, '2020-09-01 08:27:13', '2020-09-01 08:27:13', 'voyager.plantcategories.index', NULL),
(17, 2, 'Home', '/', '_self', NULL, '#000000', NULL, 1, '2020-09-01 08:34:45', '2020-09-01 08:35:44', NULL, ''),
(18, 2, 'Contact Us', '/contact-us', '_self', NULL, '#000000', NULL, 3, '2020-09-01 08:35:13', '2020-09-01 08:35:44', NULL, ''),
(19, 2, 'Ferns', '/ferns', '_self', NULL, '#000000', NULL, 2, '2020-09-01 08:35:35', '2020-09-01 08:35:44', NULL, ''),
(20, 1, 'Orders', '', '_self', 'voyager-credit-cards', NULL, NULL, 17, '2020-09-03 03:55:35', '2020-09-03 03:55:35', 'voyager.orders.index', NULL),
(21, 1, 'Order Statuses', '', '_self', NULL, NULL, NULL, 18, '2020-09-03 03:57:23', '2020-09-03 03:57:23', 'voyager.order-statuses.index', NULL),
(22, 1, 'Products', '', '_self', NULL, NULL, NULL, 19, '2020-09-04 01:06:33', '2020-09-04 01:06:33', 'voyager.products.index', NULL),
(23, 1, 'Bundles', '', '_self', 'voyager-list-add', NULL, NULL, 20, '2020-09-04 01:19:59', '2020-09-04 01:19:59', 'voyager.bundles.index', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(5, '2014_10_12_000000_create_users_table', 1),
(6, '2014_10_12_100000_create_password_resets_table', 1),
(7, '2019_08_19_000000_create_failed_jobs_table', 1),
(8, '2020_08_28_015821_create_pages_table', 1),
(9, '2020_08_28_030505_create_plants_table', 2),
(10, '2020_08_28_031022_create_categories_table', 2),
(11, '2020_08_28_072653_create_products_table', 3),
(12, '2020_08_28_073143_create_bundles_table', 3),
(13, '2020_08_28_073632_create_carts_table', 3),
(14, '2020_08_28_073925_create_orders_table', 3),
(15, '2020_08_29_050729_create_shoppingcart_table', 4),
(16, '2020_08_28_031022_create_plantcategories_table', 5),
(17, '2020_08_30_032400_create_customers_table', 5),
(18, '2020_08_30_035307_create_addresses_table', 5),
(19, '2020_09_01_014126_create_order_statuses_table', 6),
(20, '2016_01_01_000000_add_voyager_user_fields', 7),
(21, '2016_01_01_000000_create_data_types_table', 7),
(22, '2016_05_19_173453_create_menu_table', 7),
(23, '2016_10_21_190000_create_roles_table', 7),
(24, '2016_10_21_190000_create_settings_table', 7),
(25, '2016_11_30_135954_create_permission_table', 7),
(26, '2016_11_30_141208_create_permission_role_table', 7),
(27, '2016_12_26_201236_data_types__add__server_side', 7),
(28, '2017_01_13_000000_add_route_to_menu_items_table', 7),
(29, '2017_01_14_005015_create_translations_table', 7),
(30, '2017_01_15_000000_make_table_name_nullable_in_permissions_table', 7),
(31, '2017_03_06_000000_add_controller_to_data_types_table', 7),
(32, '2017_04_21_000000_add_order_to_data_rows_table', 7),
(33, '2017_07_05_210000_add_policyname_to_data_types_table', 7),
(34, '2017_08_05_000000_add_group_to_settings_table', 7),
(35, '2017_11_26_013050_add_user_role_relationship', 7),
(36, '2017_11_26_015000_create_user_roles_table', 7),
(37, '2018_03_11_000000_add_user_settings', 7),
(38, '2018_03_14_000000_add_details_to_data_types_table', 7),
(39, '2018_03_16_000000_make_settings_value_nullable', 7),
(40, '2016_01_01_000000_create_pages_table', 8),
(41, '2016_01_01_000000_create_posts_table', 8),
(42, '2016_02_15_204651_create_categories_table', 8),
(43, '2017_04_11_000000_alter_post_nullable_fields_table', 8),
(44, '2020_09_04_023405_create_contacts_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_status_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cart` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `gst` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `user_id`, `order_status_id`, `address_id`, `email`, `name`, `address`, `city`, `state`, `postcode`, `phone`, `cart`, `comments`, `tax`, `gst`, `total`, `description`, `created_at`, `updated_at`) VALUES
(7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-01 03:14:17', '2020-09-01 03:14:17'),
(8, NULL, NULL, 2, 2, 'test@example.com', 'Test Sender', '1 Main St', 'Melton South', 'Vic', '3338', '0444 444 444', '{\"2\":[{\"rowId\":\"370d08585360f5c568b18d1f2e4ca1df\",\"id\":\"2\",\"name\":\"Paulownia fortunei Guangdong Select - Farm Pack\",\"qty\":1,\"price\":100,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"100.00\",\"model\":null}],\"5\":[{\"rowId\":\"468399581342505c47f4615b81bedaa9\",\"id\":\"5\",\"name\":\"Paulownia fortunei Guangdong Select - Woodland Pack\",\"qty\":1,\"price\":667,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"667.00\",\"model\":null}]}', NULL, 0.00, NULL, 767.00, NULL, '2020-09-01 03:15:11', '2020-09-01 04:11:07'),
(9, NULL, NULL, 3, 3, 'test@example.com', 'Test Buyer', '1 Main St', 'Melton South', 'Vic', '3338', '03 7010 1234', '{\"2\":[{\"rowId\":\"370d08585360f5c568b18d1f2e4ca1df\",\"id\":\"2\",\"name\":\"Paulownia fortunei Guangdong Select - Farm Pack\",\"qty\":1,\"price\":100,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"100.00\",\"model\":null}]}', NULL, 0.00, NULL, 100.00, NULL, '2020-09-03 02:29:21', '2020-09-03 04:53:51'),
(10, NULL, NULL, 3, 4, 'trace@example.com', 'Ima Test', '10 Main St', 'Mytown', 'NSW', '2000', '03 7010 1232', '{\"1\":[{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\",\"model\":{\"id\":1,\"title\":\"Paulownia fortunei Guangdong Select\",\"code\":\"PF-GS01\",\"slug\":\"paulownia-fortunei-guangdong-select\",\"image\":null,\"description\":\"<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.<\\/p>\",\"published\":1,\"created_at\":null,\"updated_at\":null}}]}', NULL, 0.00, NULL, 67.00, NULL, '2020-09-05 04:34:14', '2020-09-05 04:36:59'),
(11, NULL, NULL, 3, 5, 'joe@example.com', 'Joe', '46 Rees Road', 'Melton South', 'Vic', '3338', '03 7010 1219', '{\"1\":[{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\",\"model\":{\"id\":1,\"title\":\"Paulownia fortunei Guangdong Select\",\"code\":\"PF-GS01\",\"slug\":\"paulownia-fortunei-guangdong-select\",\"image\":null,\"description\":\"<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.<\\/p>\",\"published\":1,\"created_at\":null,\"updated_at\":null}}]}', NULL, 0.00, NULL, 67.00, NULL, '2020-09-06 23:27:32', '2020-09-07 00:07:14'),
(12, NULL, NULL, 3, 6, 'test@example.com', 'Joe Doe', '1 Main St', 'Melton South', 'Vic', '3338', '03 7010 1234', '{\"1\":[{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\",\"model\":{\"id\":1,\"title\":\"Paulownia fortunei Guangdong Select\",\"code\":\"PF-GS01\",\"slug\":\"paulownia-fortunei-guangdong-select\",\"image\":null,\"description\":\"<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.<\\/p>\",\"published\":1,\"created_at\":null,\"updated_at\":null}}]}', NULL, 0.00, NULL, 67.00, NULL, '2020-09-07 00:00:27', '2020-09-07 00:02:51'),
(13, NULL, NULL, 3, 7, 'test@example.com', 'Test Sender', '1 Main St', 'Melton South', 'Vic', '3338', '03 7010 1234', '{\"1\":[{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\",\"model\":{\"id\":1,\"title\":\"Paulownia fortunei Guangdong Select\",\"code\":\"PF-GS01\",\"slug\":\"paulownia-fortunei-guangdong-select\",\"image\":null,\"description\":\"<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.<\\/p>\",\"published\":1,\"created_at\":null,\"updated_at\":null}}]}', NULL, 0.00, NULL, 67.00, NULL, '2020-09-07 00:40:59', '2020-09-07 00:42:57'),
(14, NULL, NULL, 3, 8, 'test@example.com', 'Joe Doe', '1 Main St', 'Melton South', 'Vic', '3338', '03 7010 1234', '{\"1\":[{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\",\"model\":{\"id\":1,\"title\":\"Paulownia fortunei Guangdong Select\",\"code\":\"PF-GS01\",\"slug\":\"paulownia-fortunei-guangdong-select\",\"image\":null,\"description\":\"<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.<\\/p>\",\"published\":1,\"created_at\":null,\"updated_at\":null}}]}', NULL, 0.00, 6.70, 67.00, NULL, '2020-09-07 01:29:25', '2020-09-07 01:31:14'),
(15, NULL, NULL, 1, NULL, 'james@toadgully.com.au', 'James Lawrence', NULL, NULL, NULL, NULL, '2781636', '{\"1\":[{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\",\"model\":{\"id\":1,\"title\":\"Paulownia fortunei Guangdong Select\",\"code\":\"PF-GS01\",\"slug\":\"paulownia-fortunei-guangdong-select\",\"image\":null,\"description\":\"<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.<\\/p>\",\"published\":\"1\",\"created_at\":null,\"updated_at\":null}}]}', NULL, 0.00, 6.70, 67.00, NULL, '2020-09-06 23:47:15', '2020-09-06 23:47:15'),
(16, NULL, NULL, 1, NULL, 'james@toadgully.com.au', 'James Lawrence', NULL, NULL, NULL, NULL, '0359835688', '{\"1\":[{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\",\"model\":{\"id\":1,\"title\":\"Paulownia fortunei Guangdong Select\",\"code\":\"PF-GS01\",\"slug\":\"paulownia-fortunei-guangdong-select\",\"image\":null,\"description\":\"<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.<\\/p>\",\"published\":\"1\",\"created_at\":null,\"updated_at\":null}}]}', NULL, 0.00, 6.70, 67.00, NULL, '2020-09-06 23:47:49', '2020-09-06 23:47:49'),
(17, NULL, NULL, 1, NULL, 'james@notreal', 'James Lawrence', NULL, NULL, NULL, NULL, '0359835688', '{\"1\":[{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\",\"model\":{\"id\":1,\"title\":\"Paulownia fortunei Guangdong Select\",\"code\":\"PF-GS01\",\"slug\":\"paulownia-fortunei-guangdong-select\",\"image\":null,\"description\":\"<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.<\\/p>\",\"published\":\"1\",\"created_at\":null,\"updated_at\":null}}]}', NULL, 0.00, 6.70, 67.00, NULL, '2020-09-06 23:48:04', '2020-09-06 23:48:04'),
(18, NULL, NULL, 1, NULL, 'james@toadgully.com.au', 'James Lawrence', NULL, NULL, NULL, NULL, '0359835688', '{\"1\":[{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\",\"model\":{\"id\":1,\"title\":\"Paulownia fortunei Guangdong Select\",\"code\":\"PF-GS01\",\"slug\":\"paulownia-fortunei-guangdong-select\",\"image\":null,\"description\":\"<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.<\\/p>\",\"published\":\"1\",\"created_at\":null,\"updated_at\":null}}]}', NULL, 0.00, 6.70, 67.00, NULL, '2020-09-06 23:50:22', '2020-09-06 23:50:22'),
(19, NULL, NULL, 3, 9, 'james@toadgully.com.au', 'James Lawrence', '361 Stumpy Gully Rd', 'Balnarring', 'Vic', '3926', '0359835688', '{\"4\":[{\"rowId\":\"efb26e2c6ab6bd4d1323288923522d4e\",\"id\":\"4\",\"name\":\"Paulownia fortunei Guangdong Select - Grove Pack\",\"qty\":1,\"price\":417,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"417.00\",\"model\":null}]}', NULL, 0.00, 41.70, 417.00, NULL, '2020-09-07 14:41:06', '2020-09-07 14:48:52'),
(20, NULL, NULL, 3, 10, 'test@example.com', 'Test Buyer', '1 Main St', 'Melton South', 'ACT', '3338', '03 7010 1234', '{\"1\":[{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\",\"model\":{\"id\":1,\"title\":\"Paulownia fortunei Guangdong Select\",\"code\":\"PF-GS01\",\"slug\":\"paulownia-fortunei-guangdong-select\",\"image\":null,\"description\":\"<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.<\\/p>\",\"published\":\"1\",\"created_at\":null,\"updated_at\":null}}]}', NULL, 0.00, 6.70, 67.00, NULL, '2020-09-07 18:08:42', '2020-09-07 18:09:27'),
(21, NULL, NULL, 3, 12, 'james@toadgully.com.au', 'James', '361 Stumpy Gully Rd', 'Balnarring', 'Vic', '3926', '0359835688', '{\"1\":[{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\",\"model\":{\"id\":1,\"title\":\"Paulownia fortunei Guangdong Select\",\"code\":\"PF-GS01\",\"slug\":\"paulownia-fortunei-guangdong-select\",\"image\":null,\"description\":\"<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.<\\/p>\",\"published\":\"1\",\"created_at\":null,\"updated_at\":null}}]}', NULL, 0.00, 6.70, 67.00, NULL, '2020-09-07 19:34:38', '2020-09-07 19:52:58'),
(22, NULL, NULL, 1, NULL, 'joe@example.com', 'Joe Doe', NULL, NULL, NULL, NULL, '0370101219', '{\"1\":[{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\",\"model\":{\"id\":1,\"title\":\"Paulownia fortunei Guangdong Select\",\"code\":\"PF-GS01\",\"slug\":\"paulownia-fortunei-guangdong-select\",\"image\":null,\"description\":\"<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.<\\/p>\",\"published\":\"1\",\"created_at\":null,\"updated_at\":null}}]}', NULL, 0.00, 6.70, 67.00, NULL, '2020-09-07 20:37:22', '2020-09-07 20:37:22'),
(23, NULL, NULL, 1, 16, 'test@example.com', 'Test Sender', '1 Main St', 'Melton South', 'ACT', '7000', '03 7010 1234', '{\"1\":[{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\",\"model\":{\"id\":1,\"title\":\"Paulownia fortunei Guangdong Select\",\"code\":\"PF-GS01\",\"slug\":\"paulownia-fortunei-guangdong-select\",\"image\":null,\"description\":\"<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.<\\/p>\",\"published\":\"1\",\"created_at\":null,\"updated_at\":null}}]}', NULL, 0.00, 6.70, 67.00, NULL, '2020-09-07 20:38:00', '2020-09-07 21:14:11'),
(24, NULL, NULL, 1, NULL, 'test@example.com', 'Test Sender', NULL, NULL, NULL, NULL, '01 7010 1234', '{\"1\":[{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\",\"model\":{\"id\":1,\"title\":\"Paulownia fortunei Guangdong Select\",\"code\":\"PF-GS01\",\"slug\":\"paulownia-fortunei-guangdong-select\",\"image\":null,\"description\":\"<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.<\\/p>\",\"published\":\"1\",\"created_at\":null,\"updated_at\":null}}]}', NULL, 0.00, 6.70, 67.00, NULL, '2020-09-07 22:09:33', '2020-09-07 22:09:33');

-- --------------------------------------------------------

--
-- Table structure for table `order_statuses`
--

CREATE TABLE `order_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_statuses`
--

INSERT INTO `order_statuses` (`id`, `title`, `body`, `created_at`, `updated_at`) VALUES
(1, 'In Cart', NULL, NULL, NULL),
(2, 'Invoiced', NULL, NULL, NULL),
(3, 'Paid', NULL, NULL, NULL),
(4, 'Shipped', NULL, NULL, NULL),
(5, 'On Hold', NULL, NULL, NULL),
(6, 'Cancelled', NULL, NULL, NULL),
(7, 'Refunded', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `author_id`, `title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Home', 'Toad Gully Growers is a wholesale production nursery on the Mornington Peninsula, Victoria, Australia growing ferns, succulents and foliage plants for sale into the nursery industry. We also sell bare root Paulownia trees online, with postal delivery in Australia to all states except Tas & WA.', '<p>Toad Gully Growers is a wholesale production nursery on the Mornington Peninsula, Victoria, Australia growing ferns, succulents and foliage plants for sale into the nursery industry. We also sell bare root Paulownia trees online, with postal delivery within Australia.</p>\r\n<p>We grow a wide range of potted ferns, mostly in 125mm and 180mm pots, including maidenhairs, tree ferns, bird&rsquo;s nest and others suited to indoors and garden. We have a popular line of small hanging potted succulents and supply large pots of lush foliage including Elephant Ears in the summer months and numerous varieties of tree ferns in 250mm pots.</p>\r\n<p>Toad Gully Growers recognises the need for consistent high-quality stock. When ordering our plants, you can be confident that your customers will be impressed. We understand that for a retail nursery you need plants that look fantastic and will be snapped up quickly when times are good, but are also resilient and will have a good &lsquo;shelf life&rsquo; when sales may not be as easy to come by as we&rsquo;d like. With our in-house potting mix production and various growing environments, we make sure each variety is produced according to its needs. This results in well grown plants in the best of health. We are confident that your customers will be happy with their purchase when they buy a Toad Gully plant.</p>\r\n<p>Sidebar? OPENING HOURS</p>\r\n<p>We are not open to the public.</p>\r\n<p>Wholesale sales visit by appointment.</p>\r\n<p>We only sell to ABN registered retail or landscaping businesses. (Except for seasonal postal delivery of Paulownia trees.)</p>', 'pages/page1.jpg', '/', 'Toad Gully Growers is a wholesale production nursery on the Mornington Peninsula, Victoria, Australia growing ferns, succulents and foliage plants for sale into the nursery industry. We also sell bare root Paulownia trees online, with postal delivery within Australia.', 'nursery, plants, ferns, paulownia, wholesale', 'ACTIVE', '2020-09-01 08:07:52', '2020-09-11 16:37:13'),
(2, 1, 'Ferns', 'Wholesale only.  Our ferns and other potted plants are only available to ABN registered retail or landscaping businesses.', '<p>Wholesale only.&nbsp; Our ferns and other potted plants are only available to ABN registered retail or landscaping businesses.</p>', NULL, 'ferns', 'Wholesale only.  Our ferns and other potted plants are only available to ABN registered retail or landscaping businesses.', 'ferns', 'ACTIVE', '2020-09-01 23:55:16', '2020-09-01 23:55:16'),
(3, 1, 'Paulownia', 'Paulownia make a fantastic fast-growing addition to a farm when planted in a small, easily managed grove. They provide shade and fodder, beautiful flowers in spring and can be harvested for timber.\r\n\r\nToad Gully Growers supplied millions of Paulownia seedlings to plantation projects worldwide over 30 years. The motivation was to assist the climate change problem as Paulownia have the potential for rapid growth and carbon sequestration and will regenerate from the stump when harvested for timber. Some projects were successful, but many were not.', '<p>Paulownia make a fantastic fast-growing addition to a farm when planted in a small, easily managed grove. They provide shade and fodder, beautiful flowers in spring and can be harvested for timber.</p>\r\n<p>Toad Gully Growers supplied millions of Paulownia seedlings to plantation projects worldwide over 30 years. The motivation was to assist the climate change problem as Paulownia have the potential for rapid growth and carbon sequestration and will regenerate from the stump when harvested for timber. Some projects were successful, but many were not.</p>\r\n<p>We have come to believe Paulownia are not well matched to corporate forestry. The main reasons for failure have been poor site selection, both in terms of soil type and climatic conditions and poor or insufficient management. Greed has played a large part. Often investors have been duped into funding plantations, but insufficient funding has been put into the plantation management and rather has gone to those running the schemes.</p>\r\n<p>Paulownia is a deciduous tree from east Asia, predominately China. The regions Paulownia grow in naturally have good summer rainfall and generally drier cold winter months. This means there are limited regions in Australia suited to the growth of Paulownia.&nbsp;</p>\r\n<p>Paulownia require freely draining fertile soil. They have the potential for amazingly fast growth under the correct conditions but need a lot of water and nutrition during spring to autumn to achieve this fast growth. They are prone to fatal root rot if the water level rises above 1m for more than 3 days, especially in a wet winter when they are dormant, so the soil should be mounded if it is not naturally well drained. Under preferable care, Paulownia grow almost fast enough to watch, so you are quickly rewarded for your efforts!</p>\r\n<p>Break here? Perhaps &lsquo;Read more&rsquo; to open further</p>\r\n<p>Toad Gully Growers supply Paulownia Headstarters&trade;, small bare root plants, during spring and summer. Headstarters&trade; are bare-root Paulownia trees with trimmed trunks. They are ready to plant in the ground and will regenerate a new trunk rapidly with warm weather and correct management.</p>\r\n<p>Headstarters&trade; have well-developed roots systems about the size of a large hand. These roots have a framework of thick fleshy main roots which contain the energy the tree needs to quickly regenerate in the field. The trunks are trimmed just above a strong node usually at about 150mm tall. They have many reserve buds, ready to sprout, ensuring a new trunk will develop even if some of the buds are damaged - for example by adverse weather.</p>\r\n<p>To grow Paulownia successfully you need to:</p>\r\n<ul>\r\n<li>Avoid planting during periods of extreme temperatures</li>\r\n<li>Plant only in very free draining soil &ndash; poorly drained sites need raised beds and drains</li>\r\n<li>Provide them with weed free conditions &ndash; at least for establishment</li>\r\n<li>Feed them well &ndash; to grow fast they have high fertiliser requirements</li>\r\n<li>Water well during summer but let soil dry a little before next watering (30L min per tree to start, later 100L+ but less often)</li>\r\n<li>If growing for timber they usually require some pruning to obtain clear wood</li>\r\n</ul>\r\n<h3>Spacing</h3>\r\n<p>If you are growing Paulownia for timber it is important they are not over-crowded. The maximum planting density for a clear fell harvest without thinning is 400 trees per hectare (161 per acre). This can be planted 5 x 5m or 4m in row with the rows 6.25m apart. The latter will save costs on cultivation, dripper line and maintenance works. If you can afford the space planting them wider is better &ndash; the figures given here are the closest we suggest you can plant and achieve good results under ideal conditions.</p>\r\n<p>Ornamental planting can be done at various spacing depending on the effect you want. TGG suggest a single row can be planted as close as 2m apart if you want a hedging effect or 4 metres apart for a more stately look. A double row can be planted 3m apart in a zigzag pattern or as wide as 7m apart if you want a lot of light distribution through the canopy. Paulownia will not compete well if planted within 12m of a vigorous tree like pine or eucalypt. We do not recommend planting within 6m from a structure.</p>\r\n<p>Break here? Perhaps &lsquo;Read growing guide&rsquo; to open further</p>\r\n<h2>Please follow this growing guide:</h2>\r\n<h3>1) Unpacking The Bags.</h3>\r\n<p>The Headstarters&trade; can be left in the plastic bags in a cool dark place for a matter of only a few days. DO NOT LEAVE IN THE BAGS IN A WARM PLACE as the plants may rot. They ideally should be unpacked and planted within 48 hours of delivery.</p>\r\n<h3>2) Holding Before Planting.</h3>\r\n<p>If you must store them, remove the plants from the plastic bags as soon as possible and immediately place them upright with their roots covered with potting mix or similar medium in a SUNNY position and keep them moist BUT NOT WET. Under these conditions they will begin to grow, so should not be held any longer than absolutely necessary as if they become too active before planting they are at a greater risk of transplant shock when planted out and may suffer wind damage if they have tall soft growth</p>\r\n<h3>3) Planting Out&nbsp;</h3>\r\n<p>Carry the Headstarters&trade; in a way that keeps them bunched together, cool and moist, and plant them into well cultivated, friable, moist soil. If prone to waterlogging the soil should be cultivated into high mounded beds - at least 60cm higher than original soil level. The roots of the Headstarters&trade; should not be disturbed. Make sure the general mass of the roots is pointing downwards and the shallowest root is covered by 3cm of soil. Gently firm the soil around the trunk.</p>\r\n<h3>4) Fertiliser And Watereing</h3>\r\n<p>Exact fertiliser requirements depend on soil type and climate conditions, but as a guide Osmocote 9kg All Purpose Landscape Fertiliser at a rate of 250g (one cup) per tree is a good start. Sprinkle it evenly within a 30cm radius from the trunk. Further application may be needed during the season; the trees should be rich dark green and growth rapid during warm weather. This is a slow release fertiliser designed to last about 6 months. It may take time to begin to release so we suggest you water them in with a liquid fertiliser such as Seasol PowerFeed to help give an initial growth stimulus. Over time, once the trees have dinner plate sized leaves (probably in 6-8 weeks) you could add additional fertiliser to hurry their growth. Pelletised poultry manure such as Dynamic Lifter or Rooster Booster at 1 kg per tree will help them develop larger greener leaves. These act as the solar panels for the young tree, catching the sun\'s rays and converting the energy into fast growth. At this time, the trees will need to be kept well-watered too as this is when they use a lot of water for the fast growth stage. However, to begin, for the first few weeks after planting, they do not want too much water. They only need the ground to be moist, not wet. Only water heavily once the heat arrives and the trees have very large leaves.</p>\r\n<h3>5) Trunk Regeneration&nbsp;</h3>\r\n<p>When the weather is warm the trunk will regenerate from the Headstarters&trade; stump. (However even if it&rsquo;s warm it generally takes 3 to 6 weeks to sprout, so don&rsquo;t panic.) Often multiple stems sprout from the many reserve buds on Headstarters&trade;; only the strongest one should be allowed to grow. The best shoots usually grow from low on the stump. Wait until the best trunk shoots are at least 20cm tall, then trim off all but one strong one and remove any portion of the original trunk above the shoot you have selected. This shoot will then grow more strongly and straight, to become the new trunk. Headstarters&trade; planted in spring and given ideal conditions, may reach between 2 to 4 metres by autumn!</p>\r\n<h3>6) Pruning</h3>\r\n<p>Paulownia can be shaped into tall, stately trees or shorter bushy specimens depending on what you want. The removal of the tips of the branches and even the top portion of the trunk, will force regrowth lower on the stems to produce a dense, compact tree. Multi-trunked bushy trees can be continuously pruned for fodder throughout the growing season. Timber growers will want a tall straight trunk and should gradually lift prune any branches that grow on the first 4 to 6m being sure to always leave at least one third of the height of the trunk covered with leaved branches. It is usually a simple matter of removing the lower branches (generally from late summer to early winter) when they reach 2 to 3 cm diameter. This should prevent large knots in the timber. Be sure not to mistake the thick leaf stalks in the first season for branches! You should not remove the big leaves as this will slow growth. They will drop naturally by mid-winter leaving behind a pattern on the trunk which does not impact the timber.</p>\r\n<h3>7) Problems, Queries, Comment Suggestions</h3>\r\n<p>Contact us, preferably using our contact form. We hope you enjoy growing Toad Gully Growers Paulownia Headstarters&trade;.</p>', NULL, 'paulownia', 'Paulownia make a fantastic fast-growing addition to a farm when planted in a small, easily managed grove. They provide shade and fodder, beautiful flowers in spring and can be harvested for timber.', 'Paulownia', 'ACTIVE', '2020-09-01 23:57:26', '2020-09-01 23:57:26'),
(4, 1, 'Contact Us', 'VISIT BY APPOINTMENT ONLY Important: We no longer accept international orders.', '<p>Current Time Melbourne, Australia: insert clock</p>\r\n<p>&nbsp;</p>\r\n<p>VISIT BY APPOINTMENT ONLY</p>\r\n<p>&nbsp;</p>\r\n<p>Important: We no longer accept international orders.</p>\r\n<p>&nbsp;</p>\r\n<p>Toad Gully Growers</p>\r\n<p>361 Stumpy Gully Rd</p>\r\n<p>Balnarring Vic, 3926</p>\r\n<p>&nbsp;</p>\r\n<p>ABN 61 173 928 602</p>\r\n<p>&nbsp;</p>\r\n<p>tel 03 5983 5688 8:00am - 5:00pm Monday to Friday Melbourne time</p>\r\n<p>&nbsp;</p>\r\n<p>You can leave a message using the contact form below:</p>', NULL, 'contact-us', 'Contact us', 'contact', 'ACTIVE', '2020-09-01 23:59:31', '2020-09-02 00:06:33'),
(5, 1, 'Products', 'Sales within Australia only.\r\n\r\nWe are unable to supply Tasmania or Western Australia.', '<article class=\"message is-warning\">\r\n<div class=\"message-body\">\r\n<p>Sales within Australia only.</p>\r\n<p><em>We are unable to supply Tasmania or Western Australia.</em></p>\r\n<p><em>&nbsp;</em></p>\r\n</div>\r\n</article>\r\n<p>All prices include GST and delivery (to all states except Tas &amp; WA).</p>\r\n<p>Growing information is available on the Paulownia page.</p>', NULL, 'products', 'Products', 'prdoucats', 'ACTIVE', '2020-09-02 00:01:48', '2020-09-07 16:40:20'),
(6, 1, 'Cart', 'cart', NULL, NULL, 'cart', 'cart', 'cart', 'ACTIVE', '2020-09-02 00:03:05', '2020-09-04 02:13:42'),
(7, 1, 'Checkout', 'Checkout', '<p>Checkout</p>', NULL, 'checkout', 'checkout', 'checkout', 'ACTIVE', '2020-09-05 04:24:15', '2020-09-05 04:24:15'),
(8, 1, 'Thankyou', 'Thank you', '<p>Thank you</p>', NULL, 'thankyou', 'thankyou', 'thankyou', 'ACTIVE', '2020-09-05 04:54:26', '2020-09-05 04:54:26');

-- --------------------------------------------------------

--
-- Table structure for table `pagesbak`
--

CREATE TABLE `pagesbak` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pagesbak`
--

INSERT INTO `pagesbak` (`id`, `title`, `slug`, `body`, `meta_title`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(1, 'Home', '/', '<p>Toad Gully Growers is a wholesale production nursery on the Mornington Peninsula, Victoria, Australia growing ferns, succulents and foliage plants for sale into the nursery industry. We also sell bare root Paulownia trees online, with postal delivery within Australia.</p>\r\n<p>We grow a wide range of potted ferns, mostly in 125mm and 180mm pots, including maidenhairs, tree ferns, bird&rsquo;s nest and others suited to indoors and garden. We have a popular line of small hanging potted succulents and supply large pots of lush foliage including Elephant Ears in the summer months and numerous varieties of tree ferns in 250mm pots.</p>\r\n<p>Toad Gully Growers recognises the need for consistent high-quality stock. When ordering our plants, you can be confident that your customers will be impressed. We understand that for a retail nursery you need plants that look fantastic and will be snapped up quickly when times are good, but are also resilient and will have a good &lsquo;shelf life&rsquo; when sales may not be as easy to come by as we&rsquo;d like. With our in-house potting mix production and various growing environments, we make sure each variety is produced according to its needs. This results in well grown plants in the best of health. We are confident that your customers will be happy with their purchase when they buy a Toad Gully plant.</p>\r\n<p>Sidebar? OPENING HOURS</p>\r\n<p>We are not open to the public.</p>\r\n<p>Wholesale sales visit by appointment.</p>\r\n<p>We only sell to ABN registered retail or landscaping businesses. (Except for seasonal postal delivery of Paulownia trees.)</p>', NULL, NULL, NULL, NULL),
(2, 'Ferns', 'ferns', '<p>Wholesale only.&nbsp; Our ferns and other potted plants are only available to ABN registered retail or landscaping businesses.</p>', NULL, NULL, NULL, NULL),
(3, 'Contact Us', 'contact-us', '<p>Current Time Melbourne, Australia: insert clock</p>\r\n<p>&nbsp;</p>\r\n<p>VISIT BY APPOINTMENT ONLY</p>\r\n<p>&nbsp;</p>\r\n<p>Important: We no longer accept international orders.</p>\r\n<p>&nbsp;</p>\r\n<p>Toad Gully Growers</p>\r\n<p>361 Stumpy Gully Rd</p>\r\n<p>Balnarring Vic, 3926</p>\r\n<p>&nbsp;</p>\r\n<p>ABN 61 173 928 602</p>\r\n<p>&nbsp;</p>\r\n<p>tel 03 5983 5688 8:00am - 5:00pm Monday to Friday Melbourne time</p>\r\n<p>&nbsp;</p>\r\n<p>You can leave a message using the contact form below:</p>', NULL, NULL, NULL, NULL),
(4, 'Paulownia', 'paulownia', '<p>Paulownia make a fantastic fast-growing addition to a farm when planted in a small, easily managed grove. They provide shade and fodder, beautiful flowers in spring and can be harvested for timber.</p>\r\n<p>Toad Gully Growers supplied millions of Paulownia seedlings to plantation projects worldwide over 30 years. The motivation was to assist the climate change problem as Paulownia have the potential for rapid growth and carbon sequestration and will regenerate from the stump when harvested for timber. Some projects were successful, but many were not.</p>\r\n<p>We have come to believe Paulownia are not well matched to corporate forestry. The main reasons for failure have been poor site selection, both in terms of soil type and climatic conditions and poor or insufficient management. Greed has played a large part. Often investors have been duped into funding plantations, but insufficient funding has been put into the plantation management and rather has gone to those running the schemes.</p>\r\n<p>Paulownia is a deciduous tree from east Asia, predominately China. The regions Paulownia grow in naturally have good summer rainfall and generally drier cold winter months. This means there are limited regions in Australia suited to the growth of Paulownia.&nbsp;</p>\r\n<p>Paulownia require freely draining fertile soil. They have the potential for amazingly fast growth under the correct conditions but need a lot of water and nutrition during spring to autumn to achieve this fast growth. They are prone to fatal root rot if the water level rises above 1m for more than 3 days, especially in a wet winter when they are dormant, so the soil should be mounded if it is not naturally well drained. Under preferable care, Paulownia grow almost fast enough to watch, so you are quickly rewarded for your efforts!</p>\r\n<p>Break here? Perhaps &lsquo;Read more&rsquo; to open further</p>\r\n<p>Toad Gully Growers supply Paulownia Headstarters&trade;, small bare root plants, during spring and summer. Headstarters&trade; are bare-root Paulownia trees with trimmed trunks. They are ready to plant in the ground and will regenerate a new trunk rapidly with warm weather and correct management.</p>\r\n<p>Headstarters&trade; have well-developed roots systems about the size of a large hand. These roots have a framework of thick fleshy main roots which contain the energy the tree needs to quickly regenerate in the field. The trunks are trimmed just above a strong node usually at about 150mm tall. They have many reserve buds, ready to sprout, ensuring a new trunk will develop even if some of the buds are damaged - for example by adverse weather.</p>\r\n<p>To grow Paulownia successfully you need to:</p>\r\n<ul>\r\n<li>Avoid planting during periods of extreme temperatures</li>\r\n<li>Plant only in very free draining soil &ndash; poorly drained sites need raised beds and drains</li>\r\n<li>Provide them with weed free conditions &ndash; at least for establishment</li>\r\n<li>Feed them well &ndash; to grow fast they have high fertiliser requirements</li>\r\n<li>Water well during summer but let soil dry a little before next watering (30L min per tree to start, later 100L+ but less often)</li>\r\n<li>If growing for timber they usually require some pruning to obtain clear wood</li>\r\n</ul>\r\n<h3>Spacing</h3>\r\n<p>If you are growing Paulownia for timber it is important they are not over-crowded. The maximum planting density for a clear fell harvest without thinning is 400 trees per hectare (161 per acre). This can be planted 5 x 5m or 4m in row with the rows 6.25m apart. The latter will save costs on cultivation, dripper line and maintenance works. If you can afford the space planting them wider is better &ndash; the figures given here are the closest we suggest you can plant and achieve good results under ideal conditions.</p>\r\n<p>Ornamental planting can be done at various spacing depending on the effect you want. TGG suggest a single row can be planted as close as 2m apart if you want a hedging effect or 4 metres apart for a more stately look. A double row can be planted 3m apart in a zigzag pattern or as wide as 7m apart if you want a lot of light distribution through the canopy. Paulownia will not compete well if planted within 12m of a vigorous tree like pine or eucalypt. We do not recommend planting within 6m from a structure.</p>\r\n<p>Break here? Perhaps &lsquo;Read growing guide&rsquo; to open further</p>\r\n<h2>Please follow this growing guide:</h2>\r\n<h3>1) Unpacking The Bags. </h3>\r\n<p>The Headstarters&trade; can be left in the plastic bags in a cool dark place for a matter of only a few days. DO NOT LEAVE IN THE BAGS IN A WARM PLACE as the plants may rot. They ideally should be unpacked and planted within 48 hours of delivery.</p>\r\n<h3>2) Holding Before Planting. </h3>\r\n<p>If you must store them, remove the plants from the plastic bags as soon as possible and immediately place them upright with their roots covered with potting mix or similar medium in a SUNNY position and keep them moist BUT NOT WET. Under these conditions they will begin to grow, so should not be held any longer than absolutely necessary as if they become too active before planting they are at a greater risk of transplant shock when planted out and may suffer wind damage if they have tall soft growth</p>\r\n<h3>3) Planting Out&nbsp;</h3>\r\n<p>Carry the Headstarters&trade; in a way that keeps them bunched together, cool and moist, and plant them into well cultivated, friable, moist soil. If prone to waterlogging the soil should be cultivated into high mounded beds - at least 60cm higher than original soil level. The roots of the Headstarters&trade; should not be disturbed. Make sure the general mass of the roots is pointing downwards and the shallowest root is covered by 3cm of soil. Gently firm the soil around the trunk.</p>\r\n<h3>4) Fertiliser And Watereing</h3>\r\n<p>Exact fertiliser requirements depend on soil type and climate conditions, but as a guide Osmocote 9kg All Purpose Landscape Fertiliser at a rate of 250g (one cup) per tree is a good start. Sprinkle it evenly within a 30cm radius from the trunk. Further application may be needed during the season; the trees should be rich dark green and growth rapid during warm weather. This is a slow release fertiliser designed to last about 6 months. It may take time to begin to release so we suggest you water them in with a liquid fertiliser such as Seasol PowerFeed to help give an initial growth stimulus. Over time, once the trees have dinner plate sized leaves (probably in 6-8 weeks) you could add additional fertiliser to hurry their growth. Pelletised poultry manure such as Dynamic Lifter or Rooster Booster at 1 kg per tree will help them develop larger greener leaves. These act as the solar panels for the young tree, catching the sun\'s rays and converting the energy into fast growth. At this time, the trees will need to be kept well-watered too as this is when they use a lot of water for the fast growth stage. However, to begin, for the first few weeks after planting, they do not want too much water. They only need the ground to be moist, not wet. Only water heavily once the heat arrives and the trees have very large leaves.</p>\r\n<h3>5) Trunk Regeneration&nbsp;</h3>\r\n<p>When the weather is warm the trunk will regenerate from the Headstarters&trade; stump. (However even if it&rsquo;s warm it generally takes 3 to 6 weeks to sprout, so don&rsquo;t panic.) Often multiple stems sprout from the many reserve buds on Headstarters&trade;; only the strongest one should be allowed to grow. The best shoots usually grow from low on the stump. Wait until the best trunk shoots are at least 20cm tall, then trim off all but one strong one and remove any portion of the original trunk above the shoot you have selected. This shoot will then grow more strongly and straight, to become the new trunk. Headstarters&trade; planted in spring and given ideal conditions, may reach between 2 to 4 metres by autumn!</p>\r\n<h3>6) Pruning</h3>\r\n<p> Paulownia can be shaped into tall, stately trees or shorter bushy specimens depending on what you want. The removal of the tips of the branches and even the top portion of the trunk, will force regrowth lower on the stems to produce a dense, compact tree. Multi-trunked bushy trees can be continuously pruned for fodder throughout the growing season. Timber growers will want a tall straight trunk and should gradually lift prune any branches that grow on the first 4 to 6m being sure to always leave at least one third of the height of the trunk covered with leaved branches. It is usually a simple matter of removing the lower branches (generally from late summer to early winter) when they reach 2 to 3 cm diameter. This should prevent large knots in the timber. Be sure not to mistake the thick leaf stalks in the first season for branches! You should not remove the big leaves as this will slow growth. They will drop naturally by mid-winter leaving behind a pattern on the trunk which does not impact the timber.</p>\r\n<h3>7) Problems, Queries, Comment Suggestions</h3>\r\n<p>Contact us, preferably using our contact form. We hope you enjoy growing Toad Gully Growers Paulownia Headstarters&trade;.</p>', NULL, NULL, NULL, NULL),
(5, 'Products', 'products', '<p>Sales within Australia only.</p>\r\n<p><em>We are unable to supply Tasmania or Western Australia.</em></p>\r\n<p><em>&nbsp;</em></p>\r\n<p>All prices include GST and delivery (to all states except Tas &amp; WA).</p>', NULL, NULL, NULL, NULL),
(6, 'Cart', 'cart', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `table_name`, `created_at`, `updated_at`) VALUES
(1, 'browse_admin', NULL, '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(2, 'browse_bread', NULL, '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(3, 'browse_database', NULL, '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(4, 'browse_media', NULL, '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(5, 'browse_compass', NULL, '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(6, 'browse_menus', 'menus', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(7, 'read_menus', 'menus', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(8, 'edit_menus', 'menus', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(9, 'add_menus', 'menus', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(10, 'delete_menus', 'menus', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(11, 'browse_roles', 'roles', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(12, 'read_roles', 'roles', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(13, 'edit_roles', 'roles', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(14, 'add_roles', 'roles', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(15, 'delete_roles', 'roles', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(16, 'browse_users', 'users', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(17, 'read_users', 'users', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(18, 'edit_users', 'users', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(19, 'add_users', 'users', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(20, 'delete_users', 'users', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(21, 'browse_settings', 'settings', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(22, 'read_settings', 'settings', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(23, 'edit_settings', 'settings', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(24, 'add_settings', 'settings', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(25, 'delete_settings', 'settings', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(26, 'browse_categories', 'categories', '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(27, 'read_categories', 'categories', '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(28, 'edit_categories', 'categories', '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(29, 'add_categories', 'categories', '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(30, 'delete_categories', 'categories', '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(31, 'browse_posts', 'posts', '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(32, 'read_posts', 'posts', '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(33, 'edit_posts', 'posts', '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(34, 'add_posts', 'posts', '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(35, 'delete_posts', 'posts', '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(36, 'browse_pages', 'pages', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(37, 'read_pages', 'pages', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(38, 'edit_pages', 'pages', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(39, 'add_pages', 'pages', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(40, 'delete_pages', 'pages', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(41, 'browse_hooks', NULL, '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(42, 'browse_plants', 'plants', '2020-09-01 08:14:33', '2020-09-01 08:14:33'),
(43, 'read_plants', 'plants', '2020-09-01 08:14:33', '2020-09-01 08:14:33'),
(44, 'edit_plants', 'plants', '2020-09-01 08:14:33', '2020-09-01 08:14:33'),
(45, 'add_plants', 'plants', '2020-09-01 08:14:33', '2020-09-01 08:14:33'),
(46, 'delete_plants', 'plants', '2020-09-01 08:14:33', '2020-09-01 08:14:33'),
(47, 'browse_plantcategories', 'plantcategories', '2020-09-01 08:27:13', '2020-09-01 08:27:13'),
(48, 'read_plantcategories', 'plantcategories', '2020-09-01 08:27:13', '2020-09-01 08:27:13'),
(49, 'edit_plantcategories', 'plantcategories', '2020-09-01 08:27:13', '2020-09-01 08:27:13'),
(50, 'add_plantcategories', 'plantcategories', '2020-09-01 08:27:13', '2020-09-01 08:27:13'),
(51, 'delete_plantcategories', 'plantcategories', '2020-09-01 08:27:13', '2020-09-01 08:27:13'),
(52, 'browse_orders', 'orders', '2020-09-03 03:55:35', '2020-09-03 03:55:35'),
(53, 'read_orders', 'orders', '2020-09-03 03:55:35', '2020-09-03 03:55:35'),
(54, 'edit_orders', 'orders', '2020-09-03 03:55:35', '2020-09-03 03:55:35'),
(55, 'add_orders', 'orders', '2020-09-03 03:55:35', '2020-09-03 03:55:35'),
(56, 'delete_orders', 'orders', '2020-09-03 03:55:35', '2020-09-03 03:55:35'),
(57, 'browse_order_statuses', 'order_statuses', '2020-09-03 03:57:23', '2020-09-03 03:57:23'),
(58, 'read_order_statuses', 'order_statuses', '2020-09-03 03:57:23', '2020-09-03 03:57:23'),
(59, 'edit_order_statuses', 'order_statuses', '2020-09-03 03:57:23', '2020-09-03 03:57:23'),
(60, 'add_order_statuses', 'order_statuses', '2020-09-03 03:57:23', '2020-09-03 03:57:23'),
(61, 'delete_order_statuses', 'order_statuses', '2020-09-03 03:57:23', '2020-09-03 03:57:23'),
(62, 'browse_products', 'products', '2020-09-04 01:06:33', '2020-09-04 01:06:33'),
(63, 'read_products', 'products', '2020-09-04 01:06:33', '2020-09-04 01:06:33'),
(64, 'edit_products', 'products', '2020-09-04 01:06:33', '2020-09-04 01:06:33'),
(65, 'add_products', 'products', '2020-09-04 01:06:33', '2020-09-04 01:06:33'),
(66, 'delete_products', 'products', '2020-09-04 01:06:33', '2020-09-04 01:06:33'),
(67, 'browse_bundles', 'bundles', '2020-09-04 01:19:59', '2020-09-04 01:19:59'),
(68, 'read_bundles', 'bundles', '2020-09-04 01:19:59', '2020-09-04 01:19:59'),
(69, 'edit_bundles', 'bundles', '2020-09-04 01:19:59', '2020-09-04 01:19:59'),
(70, 'add_bundles', 'bundles', '2020-09-04 01:19:59', '2020-09-04 01:19:59'),
(71, 'delete_bundles', 'bundles', '2020-09-04 01:19:59', '2020-09-04 01:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1);

-- --------------------------------------------------------

--
-- Table structure for table `plantcategories`
--

CREATE TABLE `plantcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plantcategories`
--

INSERT INTO `plantcategories` (`id`, `title`, `slug`, `description`, `published`, `created_at`, `updated_at`) VALUES
(1, 'Ferns', 'ferns', NULL, 1, NULL, NULL),
(2, 'Paulownia', 'paulownia', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `plants`
--

CREATE TABLE `plants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `botanical_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  `promoted` tinyint(1) DEFAULT NULL,
  `plantcategory_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plants`
--

INSERT INTO `plants` (`id`, `title`, `botanical_name`, `image`, `description`, `published`, `promoted`, `plantcategory_id`, `created_at`, `updated_at`) VALUES
(1, 'Maidenhair Fern', 'Adiantum raddianum \'Fragrans\'  ', NULL, 'Graceful indoor, patio or understory garden plant. Protect from direct sun, drying winds & keep moist', 1, NULL, 1, NULL, NULL),
(2, 'Pacific Maid Maidenhair Fern', 'Adiantum raddianum \'Pacific Maid\'', NULL, 'Graceful indoor, patio or understory garden plant. Protect from direct sun, drying winds & keep moist.', 1, 0, 1, NULL, NULL),
(23, 'Upside-Down Fern', 'Arachnoides standishii', NULL, 'Hardy Japanese woodland fern. Thinly textured fronds show the spores underside, hence the name.\r\n', 1, NULL, 1, NULL, NULL),
(24, 'Shredded Spleenwort', 'Asplenium aethiopicum', NULL, 'Grows on or amongst rocks in the Aussie bush. Tough fronds to 40cm. Indoor or shady garden.\r\n', 1, NULL, 1, NULL, NULL),
(25, 'Bird\'s Nest Fern', 'Asplenium australasicum', NULL, 'Robust Australian fern to 2m. Indoor, well-drained garden or as epiphyte on tree or rock. Light shade.\r\n', 1, NULL, 1, NULL, NULL),
(26, 'Hen And Chicken Fern', 'Asplenium bulbiferum', NULL, 'Delicate looking but easy and adaptable. Indoor or shady garden. Grows baby ferns on fronds to 1.2m.', 1, 0, 1, NULL, '2020-09-01 14:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('PUBLISHED','DRAFT','PENDING') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DRAFT',
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `category_id`, `title`, `seo_title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `featured`, `created_at`, `updated_at`) VALUES
(1, 0, NULL, 'Lorem Ipsum Post', NULL, 'This is the excerpt for the Lorem Ipsum Post', '<p>This is the body of the lorem ipsum post</p>', 'posts/post1.jpg', 'lorem-ipsum-post', 'This is the meta description', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(2, 0, NULL, 'My Sample Post', NULL, 'This is the excerpt for the sample Post', '<p>This is the body for the sample post, which includes the body.</p>\n                <h2>We can use all kinds of format!</h2>\n                <p>And include a bunch of other stuff.</p>', 'posts/post2.jpg', 'my-sample-post', 'Meta Description for sample post', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(3, 0, NULL, 'Latest Post', NULL, 'This is the excerpt for the latest post', '<p>This is the body for the latest post</p>', 'posts/post3.jpg', 'latest-post', 'This is the meta description', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2020-09-01 08:07:51', '2020-09-01 08:07:51'),
(4, 0, NULL, 'Yarr Post', NULL, 'Reef sails nipperkin bring a spring upon her cable coffer jury mast spike marooned Pieces of Eight poop deck pillage. Clipper driver coxswain galleon hempen halter come about pressgang gangplank boatswain swing the lead. Nipperkin yard skysail swab lanyard Blimey bilge water ho quarter Buccaneer.', '<p>Swab deadlights Buccaneer fire ship square-rigged dance the hempen jig weigh anchor cackle fruit grog furl. Crack Jennys tea cup chase guns pressgang hearties spirits hogshead Gold Road six pounders fathom measured fer yer chains. Main sheet provost come about trysail barkadeer crimp scuttle mizzenmast brig plunder.</p>\n<p>Mizzen league keelhaul galleon tender cog chase Barbary Coast doubloon crack Jennys tea cup. Blow the man down lugsail fire ship pinnace cackle fruit line warp Admiral of the Black strike colors doubloon. Tackle Jack Ketch come about crimp rum draft scuppers run a shot across the bow haul wind maroon.</p>\n<p>Interloper heave down list driver pressgang holystone scuppers tackle scallywag bilged on her anchor. Jack Tar interloper draught grapple mizzenmast hulk knave cable transom hogshead. Gaff pillage to go on account grog aft chase guns piracy yardarm knave clap of thunder.</p>', 'posts/post4.jpg', 'yarr-post', 'this be a meta descript', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2020-09-01 08:07:51', '2020-09-01 08:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `code`, `slug`, `image`, `description`, `published`, `created_at`, `updated_at`) VALUES
(1, 'Paulownia fortunei Guangdong Select', 'PF-GS01', 'paulownia-fortunei-guangdong-select', NULL, '<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.</p>', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', '2020-09-01 08:03:52', '2020-09-01 08:03:52'),
(2, 'user', 'Normal User', '2020-09-01 08:03:52', '2020-09-01 08:03:52');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `display_name`, `value`, `details`, `type`, `order`, `group`) VALUES
(1, 'site.title', 'Site Title', 'Toad Gully Growers', '', 'text', 1, 'Site'),
(2, 'site.description', 'Site Description', 'Site Description', '', 'text', 2, 'Site'),
(3, 'site.logo', 'Site Logo', '', '', 'image', 3, 'Site'),
(4, 'site.google_analytics_tracking_id', 'Google Analytics Tracking ID', NULL, '', 'text', 4, 'Site'),
(5, 'admin.bg_image', 'Admin Background Image', '', '', 'image', 5, 'Admin'),
(6, 'admin.title', 'Admin Title', 'Voyager', '', 'text', 1, 'Admin'),
(7, 'admin.description', 'Admin Description', 'Welcome to Voyager. The Missing Admin for Laravel', '', 'text', 2, 'Admin'),
(8, 'admin.loader', 'Admin Loader', '', '', 'image', 3, 'Admin'),
(9, 'admin.icon_image', 'Admin Icon Image', '', '', 'image', 4, 'Admin'),
(10, 'admin.google_analytics_client_id', 'Google Analytics Client ID (used for admin dashboard)', NULL, '', 'text', 1, 'Admin'),
(11, 'site.abn', 'ABN', '00 123 456 789', NULL, 'text', 6, 'Site');

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int(10) UNSIGNED NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `table_name`, `column_name`, `foreign_key`, `locale`, `value`, `created_at`, `updated_at`) VALUES
(1, 'data_types', 'display_name_singular', 5, 'pt', 'Post', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(2, 'data_types', 'display_name_singular', 6, 'pt', 'Página', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(3, 'data_types', 'display_name_singular', 1, 'pt', 'Utilizador', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(4, 'data_types', 'display_name_singular', 4, 'pt', 'Categoria', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(5, 'data_types', 'display_name_singular', 2, 'pt', 'Menu', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(6, 'data_types', 'display_name_singular', 3, 'pt', 'Função', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(7, 'data_types', 'display_name_plural', 5, 'pt', 'Posts', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(8, 'data_types', 'display_name_plural', 6, 'pt', 'Páginas', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(9, 'data_types', 'display_name_plural', 1, 'pt', 'Utilizadores', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(10, 'data_types', 'display_name_plural', 4, 'pt', 'Categorias', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(11, 'data_types', 'display_name_plural', 2, 'pt', 'Menus', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(12, 'data_types', 'display_name_plural', 3, 'pt', 'Funções', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(13, 'categories', 'slug', 1, 'pt', 'categoria-1', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(14, 'categories', 'name', 1, 'pt', 'Categoria 1', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(15, 'categories', 'slug', 2, 'pt', 'categoria-2', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(16, 'categories', 'name', 2, 'pt', 'Categoria 2', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(17, 'pages', 'title', 1, 'pt', 'Olá Mundo', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(18, 'pages', 'slug', 1, 'pt', 'ola-mundo', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(19, 'pages', 'body', 1, 'pt', '<p>Olá Mundo. Scallywag grog swab Cat o\'nine tails scuttle rigging hardtack cable nipper Yellow Jack. Handsomely spirits knave lad killick landlubber or just lubber deadlights chantey pinnace crack Jennys tea cup. Provost long clothes black spot Yellow Jack bilged on her anchor league lateen sail case shot lee tackle.</p>\r\n<p>Ballast spirits fluke topmast me quarterdeck schooner landlubber or just lubber gabion belaying pin. Pinnace stern galleon starboard warp carouser to go on account dance the hempen jig jolly boat measured fer yer chains. Man-of-war fire in the hole nipperkin handsomely doubloon barkadeer Brethren of the Coast gibbet driver squiffy.</p>', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(20, 'menu_items', 'title', 1, 'pt', 'Painel de Controle', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(21, 'menu_items', 'title', 2, 'pt', 'Media', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(22, 'menu_items', 'title', 12, 'pt', 'Publicações', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(23, 'menu_items', 'title', 3, 'pt', 'Utilizadores', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(24, 'menu_items', 'title', 11, 'pt', 'Categorias', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(25, 'menu_items', 'title', 13, 'pt', 'Páginas', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(26, 'menu_items', 'title', 4, 'pt', 'Funções', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(27, 'menu_items', 'title', 5, 'pt', 'Ferramentas', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(28, 'menu_items', 'title', 6, 'pt', 'Menus', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(29, 'menu_items', 'title', 7, 'pt', 'Base de dados', '2020-09-01 08:07:52', '2020-09-01 08:07:52'),
(30, 'menu_items', 'title', 10, 'pt', 'Configurações', '2020-09-01 08:07:52', '2020-09-01 08:07:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `settings`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'admin@admin.com', 'users/default.png', NULL, '$2y$10$ThHqYNA6C8c24Qkk2Nkw6OR8k0cI9n7M3cMWx9KZbgpCB7GsNIgCm', 'dp85sWnXROsqX4V4V8eVUhQdH6dtVjqJaYke9MbEA9ZmqQb80ufVtuaBFPJ6', NULL, '2020-09-01 08:07:51', '2020-09-01 08:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bundles`
--
ALTER TABLE `bundles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_rows`
--
ALTER TABLE `data_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_rows_data_type_id_foreign` (`data_type_id`);

--
-- Indexes for table `data_types`
--
ALTER TABLE `data_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_types_name_unique` (`name`),
  ADD UNIQUE KEY `data_types_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `pagesbak`
--
ALTER TABLE `pagesbak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_key_index` (`key`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_permission_id_index` (`permission_id`),
  ADD KEY `permission_role_role_id_index` (`role_id`);

--
-- Indexes for table `plantcategories`
--
ALTER TABLE `plantcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plants`
--
ALTER TABLE `plants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`identifier`,`instance`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `translations_table_name_column_name_foreign_key_locale_unique` (`table_name`,`column_name`,`foreign_key`,`locale`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `user_roles_user_id_index` (`user_id`),
  ADD KEY `user_roles_role_id_index` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `bundles`
--
ALTER TABLE `bundles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `data_rows`
--
ALTER TABLE `data_rows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `data_types`
--
ALTER TABLE `data_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pagesbak`
--
ALTER TABLE `pagesbak`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `plantcategories`
--
ALTER TABLE `plantcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `plants`
--
ALTER TABLE `plants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `data_rows`
--
ALTER TABLE `data_rows`
  ADD CONSTRAINT `data_rows_data_type_id_foreign` FOREIGN KEY (`data_type_id`) REFERENCES `data_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
