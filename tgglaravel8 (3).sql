-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Oct 22, 2020 at 05:00 AM
-- Server version: 8.0.21
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tgglaravel8`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` int NOT NULL,
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
(1, 13, NULL, '1 Main St', NULL, 'Melton South', 'Vic', '3338', 'Australia', '2020-09-12 08:02:57', '2020-09-12 08:02:57'),
(2, 14, NULL, '46 Rees Road', NULL, 'Melton South', 'Vic', '3338', 'Australia', '2020-09-16 05:04:35', '2020-09-16 05:04:35'),
(3, 15, NULL, '46 Rees Road', NULL, 'Melton South', 'Vic', '3338', 'Australia', '2020-09-16 05:18:12', '2020-09-16 05:18:12'),
(4, 16, NULL, '46 Rees Road', NULL, 'Melton South', 'Vic', '3338', 'Australia', '2020-09-16 13:38:39', '2020-09-16 13:38:39');

-- --------------------------------------------------------

--
-- Table structure for table `backgroundcolours`
--

CREATE TABLE `backgroundcolours` (
  `id` bigint UNSIGNED NOT NULL,
  `background` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `css` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `backgroundcolours`
--

INSERT INTO `backgroundcolours` (`id`, `background`, `css`, `created_at`, `updated_at`) VALUES
(1, 'has-text-white', 'has-background-dark-green', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(2, 'has-text-black', 'has-background-light-green', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(3, 'has-text-black', 'has-background-tgg-accent1', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(4, 'has-text-black', 'has-background-tgg-accent2', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(5, 'has-text-black', 'has-background-off-white', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(6, 'has-text-black', 'has-background-slate-grey', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(7, 'has-text-white', 'has-background-trans-dark', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(8, 'has-text-black', 'has-background-trans-light', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(9, 'has-text-black', 'has-background-white', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(10, 'has-text-white', 'has-background-black', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(11, 'has-text-white', 'has-background-dark', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(12, 'has-text-white', 'has-background-primary', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(13, 'has-text-white', 'has-background-link', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(14, 'has-text-white', 'has-background-info', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(15, 'has-text-white', 'has-background-success', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(16, 'has-text-white', 'has-background-warning', '2020-10-18 06:55:29', '2020-10-18 06:55:29'),
(17, 'has-text-white', 'has-background-danger', '2020-10-18 06:55:29', '2020-10-18 06:55:29');

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `id` bigint UNSIGNED NOT NULL,
  `hero` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `weight` int NOT NULL DEFAULT '0',
  `text_colour` text COLLATE utf8mb4_unicode_ci,
  `background_colour` text COLLATE utf8mb4_unicode_ci,
  `background_image` text COLLATE utf8mb4_unicode_ci,
  `heading` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `heading_colour` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `content_width` text COLLATE utf8mb4_unicode_ci,
  `content_position` text COLLATE utf8mb4_unicode_ci,
  `cta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`id`, `hero`, `published`, `weight`, `text_colour`, `background_colour`, `background_image`, `heading`, `heading_colour`, `content`, `content_width`, `content_position`, `cta_title`, `cta_link`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, NULL, NULL, 'http://localhost/public/images/bg-front-igloo.jpg', 'Toad Gully Growers', NULL, '<p>Toad Gully Growers is a wholesale production nursery on the Mornington Peninsula, Victoria, Australia\r\n            growing ferns, succulents and foliage plants for sale into the nursery industry. We also sell bare root\r\n            Paulownia trees online, with postal delivery within Australia.</p>', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 0, 1, 0, '', NULL, NULL, NULL, NULL, '<p>We grow a wide range of potted ferns, mostly in 125mm and 180mm pots, including maidenhairs, tree\r\n                        ferns, bird’s nest and others suited to indoors and garden. We have a popular line of small\r\n                        hanging potted succulents and supply large pots of lush foliage including Elephant Ears in the\r\n                        summer months and numerous varieties of tree ferns in 250mm pots.</p>', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, '<p>Toad Gully Growers recognises the need for consistent high-quality stock. When ordering our\r\n                        plants, you can be confident that your customers will be impressed. We understand that for a\r\n                        retail nursery you need plants that look fantastic and will be snapped up quickly when times are\r\n                        good, but are also resilient and will have a good ‘shelf life’ when sales may not be as easy to\r\n                        come by as we’d like. With our in-house potting mix production and various growing environments,\r\n                        we make sure each variety is produced according to its needs. This results in well grown plants\r\n                        in the best of health. We are confident that your customers will be happy with their purchase\r\n                        when they buy a Toad Gully plant.</p>', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 0, 1, 0, NULL, NULL, NULL, 'Opening Hours', NULL, '              \r\n                    <p>We are not open to the public.</p>\r\n                    <p>Wholesale sales visit by appointment.</p>\r\n                    <p>\r\n                        We only sell to ABN registered retail or landscaping businesses. (Except for seasonal postal\r\n                        delivery of Paulownia trees.)\r\n                    </p>', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int UNSIGNED NOT NULL,
  `parent_id` int UNSIGNED DEFAULT NULL,
  `order` int NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `order`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Category 1', 'category-1', '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(2, NULL, 1, 'Category 2', 'category-2', '2020-09-11 05:27:53', '2020-09-11 05:27:53');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
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
(1, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-12 07:06:26', '2020-09-12 07:06:26'),
(2, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-12 07:11:42', '2020-09-12 07:11:42'),
(3, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-12 07:13:37', '2020-09-12 07:13:37'),
(4, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-12 07:18:04', '2020-09-12 07:18:04'),
(5, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-12 07:25:00', '2020-09-12 07:25:00'),
(6, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-12 07:30:27', '2020-09-12 07:30:27'),
(7, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-12 07:31:46', '2020-09-12 07:31:46'),
(8, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-12 07:43:15', '2020-09-12 07:43:15'),
(9, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-12 07:45:12', '2020-09-12 07:45:12'),
(10, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-12 07:54:05', '2020-09-12 07:54:05'),
(11, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-12 07:54:44', '2020-09-12 07:54:44'),
(12, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-12 07:58:07', '2020-09-12 07:58:07'),
(13, NULL, 'Test Buyer', 'test@example.com', '03 7010 1234', '2020-09-12 08:02:28', '2020-09-12 08:02:28'),
(14, NULL, 'Derek Bell', 'lucid@lucid.com.au', '0370101219', '2020-09-16 05:04:25', '2020-09-16 05:04:25'),
(15, NULL, 'Derek Bell', 'lucid@lucid.com.au', '0370101219', '2020-09-16 05:18:04', '2020-09-16 05:18:04'),
(16, NULL, 'Joe Doe', 'joe@example.com', '0370101219', '2020-09-16 13:38:18', '2020-09-16 13:38:18');

-- --------------------------------------------------------

--
-- Table structure for table `data_rows`
--

CREATE TABLE `data_rows` (
  `id` int UNSIGNED NOT NULL,
  `data_type_id` int UNSIGNED NOT NULL,
  `field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `browse` tinyint(1) NOT NULL DEFAULT '1',
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `edit` tinyint(1) NOT NULL DEFAULT '1',
  `add` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '1',
  `details` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '1'
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
(56, 7, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(57, 7, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 2),
(58, 7, 'botanical_name', 'text', 'Botanical Name', 1, 1, 1, 1, 1, 1, '{}', 3),
(59, 7, 'image', 'image', 'Image', 0, 1, 1, 1, 1, 1, '{}', 4),
(60, 7, 'description', 'rich_text_box', 'Description', 0, 1, 1, 1, 1, 1, '{}', 5),
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
(73, 7, 'plant_belongsto_plant_category_relationship', 'relationship', 'plant_categories', 0, 1, 1, 1, 1, 1, '{\"model\":\"\\\\App\\\\Models\\\\PlantCategory\",\"table\":\"plant_categories\",\"type\":\"belongsTo\",\"column\":\"plantcategory_id\",\"key\":\"id\",\"label\":\"title\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 11),
(74, 11, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(75, 11, 'customer_id', 'text', 'Customer Id', 0, 0, 1, 1, 1, 1, '{}', 2),
(76, 11, 'user_id', 'text', 'User Id', 0, 0, 1, 1, 1, 1, '{}', 3),
(77, 11, 'order_status_id', 'text', 'Order Status Id', 1, 1, 1, 1, 1, 1, '{}', 4),
(78, 11, 'address_id', 'text', 'Address Id', 0, 0, 1, 1, 1, 1, '{}', 5),
(79, 11, 'email', 'text', 'Email', 0, 1, 1, 1, 1, 1, '{}', 6),
(80, 11, 'name', 'text', 'Name', 0, 1, 1, 1, 1, 1, '{}', 7),
(81, 11, 'address', 'text', 'Address', 0, 1, 1, 1, 1, 1, '{}', 8),
(82, 11, 'line2', 'text', 'Line2', 0, 1, 1, 1, 1, 1, '{}', 9),
(83, 11, 'city', 'text', 'City', 0, 1, 1, 1, 1, 1, '{}', 10),
(84, 11, 'state', 'text', 'State', 0, 1, 1, 1, 1, 1, '{}', 11),
(85, 11, 'postcode', 'text', 'Postcode', 0, 1, 1, 1, 1, 1, '{}', 12),
(86, 11, 'country', 'text', 'Country', 0, 0, 1, 1, 1, 1, '{}', 13),
(87, 11, 'phone', 'text', 'Phone', 0, 0, 1, 1, 1, 1, '{}', 14),
(88, 11, 'cart', 'text', 'Cart', 0, 0, 1, 1, 1, 1, '{}', 15),
(89, 11, 'description', 'text', 'Description', 0, 1, 1, 1, 1, 1, '{}', 16),
(90, 11, 'comments', 'text', 'Comments', 0, 0, 1, 1, 1, 1, '{}', 17),
(91, 11, 'tax', 'text', 'Tax', 0, 0, 1, 1, 1, 1, '{}', 18),
(92, 11, 'gst', 'text', 'Gst', 0, 0, 1, 1, 1, 1, '{}', 19),
(93, 11, 'total', 'text', 'Total', 0, 1, 1, 1, 1, 1, '{}', 20),
(94, 11, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, '{}', 21),
(95, 11, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 22),
(96, 12, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(97, 12, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 2),
(98, 12, 'body', 'text', 'Body', 0, 1, 1, 1, 1, 1, '{}', 3),
(99, 12, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, '{}', 4),
(100, 12, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 5),
(101, 11, 'order_hasone_order_status_relationship', 'relationship', 'order_statuses', 0, 1, 1, 1, 1, 1, '{\"model\":\"\\\\App\\\\Models\\\\OrderStatus\",\"table\":\"order_statuses\",\"type\":\"hasOne\",\"column\":\"id\",\"key\":\"id\",\"label\":\"title\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 23),
(102, 12, 'order_status_hasmany_order_relationship', 'relationship', 'orders', 0, 1, 1, 1, 1, 1, '{\"model\":\"\\\\App\\\\Models\\\\Order\",\"table\":\"orders\",\"type\":\"hasMany\",\"column\":\"order_status_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":null}', 6);

-- --------------------------------------------------------

--
-- Table structure for table `data_types`
--

CREATE TABLE `data_types` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT '0',
  `server_side` tinyint NOT NULL DEFAULT '0',
  `details` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_types`
--

INSERT INTO `data_types` (`id`, `name`, `slug`, `display_name_singular`, `display_name_plural`, `icon`, `model_name`, `policy_name`, `controller`, `description`, `generate_permissions`, `server_side`, `details`, `created_at`, `updated_at`) VALUES
(1, 'users', 'users', 'User', 'Users', 'voyager-person', 'TCG\\Voyager\\Models\\User', 'TCG\\Voyager\\Policies\\UserPolicy', 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController', '', 1, 0, NULL, '2020-09-11 05:27:49', '2020-09-11 05:27:49'),
(2, 'menus', 'menus', 'Menu', 'Menus', 'voyager-list', 'TCG\\Voyager\\Models\\Menu', NULL, '', '', 1, 0, NULL, '2020-09-11 05:27:49', '2020-09-11 05:27:49'),
(3, 'roles', 'roles', 'Role', 'Roles', 'voyager-lock', 'TCG\\Voyager\\Models\\Role', NULL, 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController', '', 1, 0, NULL, '2020-09-11 05:27:49', '2020-09-11 05:27:49'),
(4, 'categories', 'categories', 'Category', 'Categories', 'voyager-categories', 'TCG\\Voyager\\Models\\Category', NULL, '', '', 1, 0, NULL, '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(5, 'posts', 'posts', 'Post', 'Posts', 'voyager-news', 'TCG\\Voyager\\Models\\Post', 'TCG\\Voyager\\Policies\\PostPolicy', '', '', 1, 0, NULL, '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(6, 'pages', 'pages', 'Page', 'Pages', 'voyager-file-text', 'TCG\\Voyager\\Models\\Page', NULL, '', '', 1, 0, NULL, '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(7, 'plants', 'plants', 'Plant', 'Plants', 'voyager-leaf', 'App\\Models\\Plant', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2020-09-13 04:59:06', '2020-09-18 03:23:59'),
(8, 'plant_categories', 'plant-categories', 'Plant Category', 'Plant Categories', NULL, 'App\\Models\\PlantCategory', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2020-09-13 05:00:04', '2020-09-13 05:00:04'),
(11, 'orders', 'orders', 'Order', 'Orders', 'voyager-shop', 'App\\Models\\Order', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2020-09-18 03:22:02', '2020-09-18 03:31:36'),
(12, 'order_statuses', 'order-statuses', 'Order Status', 'Order Statuses', NULL, 'App\\Models\\OrderStatus', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2020-09-18 03:25:49', '2020-09-18 03:25:49');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2020-09-11 05:27:50', '2020-09-11 05:27:50');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int UNSIGNED NOT NULL,
  `menu_id` int UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `order` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `url`, `target`, `icon_class`, `color`, `parent_id`, `order`, `created_at`, `updated_at`, `route`, `parameters`) VALUES
(1, 1, 'Dashboard', '', '_self', 'voyager-boat', NULL, NULL, 1, '2020-09-11 05:27:50', '2020-09-11 05:27:50', 'voyager.dashboard', NULL),
(2, 1, 'Media', '', '_self', 'voyager-images', NULL, NULL, 5, '2020-09-11 05:27:50', '2020-09-11 05:27:50', 'voyager.media.index', NULL),
(3, 1, 'Users', '', '_self', 'voyager-person', NULL, NULL, 3, '2020-09-11 05:27:50', '2020-09-11 05:27:50', 'voyager.users.index', NULL),
(4, 1, 'Roles', '', '_self', 'voyager-lock', NULL, NULL, 2, '2020-09-11 05:27:50', '2020-09-11 05:27:50', 'voyager.roles.index', NULL),
(5, 1, 'Tools', '', '_self', 'voyager-tools', NULL, NULL, 9, '2020-09-11 05:27:50', '2020-09-11 05:27:50', NULL, NULL),
(6, 1, 'Menu Builder', '', '_self', 'voyager-list', NULL, 5, 10, '2020-09-11 05:27:50', '2020-09-11 05:27:50', 'voyager.menus.index', NULL),
(7, 1, 'Database', '', '_self', 'voyager-data', NULL, 5, 11, '2020-09-11 05:27:50', '2020-09-11 05:27:50', 'voyager.database.index', NULL),
(8, 1, 'Compass', '', '_self', 'voyager-compass', NULL, 5, 12, '2020-09-11 05:27:50', '2020-09-11 05:27:50', 'voyager.compass.index', NULL),
(9, 1, 'BREAD', '', '_self', 'voyager-bread', NULL, 5, 13, '2020-09-11 05:27:50', '2020-09-11 05:27:50', 'voyager.bread.index', NULL),
(10, 1, 'Settings', '', '_self', 'voyager-settings', NULL, NULL, 14, '2020-09-11 05:27:50', '2020-09-11 05:27:50', 'voyager.settings.index', NULL),
(11, 1, 'Categories', '', '_self', 'voyager-categories', NULL, NULL, 8, '2020-09-11 05:27:53', '2020-09-11 05:27:53', 'voyager.categories.index', NULL),
(12, 1, 'Posts', '', '_self', 'voyager-news', NULL, NULL, 6, '2020-09-11 05:27:53', '2020-09-11 05:27:53', 'voyager.posts.index', NULL),
(13, 1, 'Pages', '', '_self', 'voyager-file-text', NULL, NULL, 7, '2020-09-11 05:27:54', '2020-09-11 05:27:54', 'voyager.pages.index', NULL),
(14, 1, 'Hooks', '', '_self', 'voyager-hook', NULL, 5, 13, '2020-09-11 05:27:55', '2020-09-11 05:27:55', 'voyager.hooks', NULL),
(15, 1, 'Plants', '', '_self', NULL, NULL, NULL, 15, '2020-09-13 04:59:06', '2020-09-13 04:59:06', 'voyager.plants.index', NULL),
(16, 1, 'Plant Categories', '', '_self', NULL, NULL, NULL, 16, '2020-09-13 05:00:05', '2020-09-13 05:00:05', 'voyager.plant-categories.index', NULL),
(17, 1, 'Orders', '', '_self', 'voyager-shop', NULL, NULL, 17, '2020-09-18 03:22:02', '2020-09-18 03:22:02', 'voyager.orders.index', NULL),
(18, 1, 'Order Statuses', '', '_self', NULL, NULL, NULL, 18, '2020-09-18 03:25:49', '2020-09-18 03:25:49', 'voyager.order-statuses.index', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2014_10_12_200000_add_two_factor_columns_to_users_table', 2),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(6, '2020_09_11_050414_create_sessions_table', 2),
(7, '2016_01_01_000000_add_voyager_user_fields', 3),
(8, '2016_01_01_000000_create_data_types_table', 3),
(9, '2016_05_19_173453_create_menu_table', 3),
(10, '2016_10_21_190000_create_roles_table', 3),
(11, '2016_10_21_190000_create_settings_table', 3),
(12, '2016_11_30_135954_create_permission_table', 3),
(13, '2016_11_30_141208_create_permission_role_table', 3),
(14, '2016_12_26_201236_data_types__add__server_side', 3),
(15, '2017_01_13_000000_add_route_to_menu_items_table', 3),
(16, '2017_01_14_005015_create_translations_table', 3),
(17, '2017_01_15_000000_make_table_name_nullable_in_permissions_table', 3),
(18, '2017_03_06_000000_add_controller_to_data_types_table', 3),
(19, '2017_04_21_000000_add_order_to_data_rows_table', 3),
(20, '2017_07_05_210000_add_policyname_to_data_types_table', 3),
(21, '2017_08_05_000000_add_group_to_settings_table', 3),
(22, '2017_11_26_013050_add_user_role_relationship', 3),
(23, '2017_11_26_015000_create_user_roles_table', 3),
(24, '2018_03_11_000000_add_user_settings', 3),
(25, '2018_03_14_000000_add_details_to_data_types_table', 3),
(26, '2018_03_16_000000_make_settings_value_nullable', 3),
(27, '2016_01_01_000000_create_pages_table', 4),
(28, '2016_01_01_000000_create_posts_table', 4),
(29, '2016_02_15_204651_create_categories_table', 4),
(30, '2017_04_11_000000_alter_post_nullable_fields_table', 4),
(31, '2020_09_11_053942_create_plants_table', 5),
(32, '2020_09_11_134749_create_addresses_table', 5),
(33, '2020_09_11_135142_create_variations_table', 5),
(34, '2020_09_11_135255_create_carts_table', 5),
(35, '2020_09_11_135339_create_contacts_table', 5),
(36, '2020_09_11_135427_create_customers_table', 5),
(37, '2020_09_11_135514_create_orders_table', 5),
(38, '2020_09_11_135630_create_plant_categories_table', 6),
(39, '2020_09_11_135712_create_products_table', 6),
(40, '2020_09_11_141155_create_order_statuses_table', 6),
(41, '2020_09_11_143207_create_shoppingcart_table', 6),
(42, '2020_10_16_015146_create_blocks_table', 7),
(43, '2020_10_18_050344_create_textcolour_table', 8),
(44, '2020_10_18_050645_create_backgroundcolour_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `order_status_id` int NOT NULL,
  `address_id` int DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cart` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `tax` decimal(10,2) DEFAULT NULL,
  `gst` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `user_id`, `order_status_id`, `address_id`, `email`, `name`, `address`, `line2`, `city`, `state`, `postcode`, `country`, `phone`, `cart`, `description`, `comments`, `tax`, `gst`, `total`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 4, 1, 'test@example.com', 'Test Buyer', '1 Main St', NULL, 'Melton South', 'Vic', '3338', NULL, '03 7010 1234', '{\"370d08585360f5c568b18d1f2e4ca1df\":{\"rowId\":\"370d08585360f5c568b18d1f2e4ca1df\",\"id\":\"2\",\"name\":\"Paulownia fortunei Guangdong Select - Farm Pack\",\"qty\":1,\"price\":100,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"100.00\"}}', NULL, 'I\'ve added a comment. and another', '0.00', '10.00', '100.00', '2020-09-12 08:02:28', '2020-10-03 06:59:09'),
(2, NULL, NULL, 6, 2, 'lucid@lucid.com.au', 'Derek Bell', '46 Rees Road', NULL, 'Melton South', 'Vic', '3338', NULL, '0370101219', '{\"027c91341fd5cf4d2579b49c4b6a90da\":{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\"}}', NULL, NULL, '0.00', '6.70', '67.00', '2020-09-16 05:04:25', '2020-10-03 07:00:53'),
(3, NULL, NULL, 3, 3, 'lucid@lucid.com.au', 'Derek Bell', '46 Rees Road', NULL, 'Melton South', 'Vic', '3338', NULL, '0370101219', '{\"027c91341fd5cf4d2579b49c4b6a90da\":{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\"}}', NULL, NULL, '0.00', '6.70', '67.00', '2020-09-16 05:18:04', '2020-09-16 05:18:18'),
(4, NULL, NULL, 3, 4, 'joe@example.com', 'Joe Doe', '46 Rees Road', NULL, 'Melton South', 'Vic', '3338', NULL, '0370101219', '{\"027c91341fd5cf4d2579b49c4b6a90da\":{\"rowId\":\"027c91341fd5cf4d2579b49c4b6a90da\",\"id\":\"1\",\"name\":\"Paulownia fortunei Guangdong Select - Homestead Pack\",\"qty\":1,\"price\":67,\"options\":[],\"tax\":\"0.00\",\"isSaved\":false,\"subtotal\":\"67.00\"}}', NULL, NULL, '0.00', '6.70', '67.00', '2020-09-16 13:38:18', '2020-09-16 13:38:47');

-- --------------------------------------------------------

--
-- Table structure for table `order_statuses`
--

CREATE TABLE `order_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
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
  `id` int UNSIGNED NOT NULL,
  `author_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `body` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `author_id`, `title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Home', '<p>Toad Gully Growers is a wholesale production nursery on the Mornington Peninsula, Victoria, Australia growing ferns, succulents and foliage plants for sale into the nursery industry. We also sell ba<img src=\"/public/storage/photos/1/air-conditioning.jpg\" alt=\"\" />re root Paulownia trees online, with postal delivery in Australia to all states except Tas &amp; WA.</p>', '<div class=\"hero is-medium home__hero home__green\">\r\n    <div class=\"hero-body\">\r\n        <div class=\"container\">\r\n            <h1>Toad Gully Growers</h1>\r\n            <p>Toad Gully Growers is a wholesale production nursery on the Mornington Peninsula, Victoria, Australia\r\n                growing ferns, succulents and foliage plants for sale into the nursery industry. We also sell bare root\r\n                Paulownia trees online, with postal delivery within Australia.</p>\r\n        </div>\r\n    </div>\r\n</div>\r\n\r\n<div id=\"parallax-1\" class=\"hero is-medium home__hero\">\r\n    <div class=\"hero-body\">\r\n        <div class=\"container\">\r\n            <div class=\"columns\">\r\n                <div class=\"column is-6 is-offset-6 has-background-dark has-text-white px-6 py-6\">\r\n                    <p>We grow a wide range of potted ferns, mostly in 125mm and 180mm pots, including maidenhairs, tree\r\n                        ferns, bird’s nest and others suited to indoors and garden. We have a popular line of small\r\n                        hanging potted succulents and supply large pots of lush foliage including Elephant Ears in the\r\n                        summer months and numerous varieties of tree ferns in 250mm pots.</p>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>\r\n\r\n<div class=\"hero is-medium home__hero home__gradient\">\r\n    <div  class=\"hero is-medium \">\r\n    <div class=\"hero-body\">\r\n        <div class=\"container\">\r\n            <div class=\"columns\">\r\n                <div class=\"column is-6 has-background-dark has-text-white px-6 py-6\">\r\n                    <p>Toad Gully Growers recognises the need for consistent high-quality stock. When ordering our\r\n                        plants, you can be confident that your customers will be impressed. We understand that for a\r\n                        retail nursery you need plants that look fantastic and will be snapped up quickly when times are\r\n                        good, but are also resilient and will have a good ‘shelf life’ when sales may not be as easy to\r\n                        come by as we’d like. With our in-house potting mix production and various growing environments,\r\n                        we make sure each variety is produced according to its needs. This results in well grown plants\r\n                        in the best of health. We are confident that your customers will be happy with their purchase\r\n                        when they buy a Toad Gully plant.</p>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>\r\n\r\n<div id=\"parallax-2\" class=\"hero is-medium\">\r\n    <div class=\"hero-body\">\r\n        <div class=\"container\">\r\n            <div class=\"column\">\r\n                <div class=\"column content is-6 is-offset-6 has-background-dark has-text-white px-6 py-6\">\r\n                    <h2>Opening Hours</h2>\r\n                    <p>We are not open to the public.</p>\r\n                    <p>Wholesale sales visit by appointment.</p>\r\n                    <p>\r\n                        We only sell to ABN registered retail or landscaping businesses. (Except for seasonal postal\r\n                        delivery of Paulownia trees.)\r\n                    </p>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>', NULL, '/', 'Toad Gully Growers is a wholesale production nursery on the Mornington Peninsula, Victoria, Australia growing ferns, succulents and foliage plants for sale into the nursery industry. We also sell bare root Paulownia trees online, with postal delivery within Australia.', 'nursery, plants, ferns, paulownia, wholesale', 'ACTIVE', '2020-09-01 18:07:52', '2020-10-05 23:30:42'),
(2, 1, 'Ferns', 'Wholesale only.  Our ferns and other potted plants are only available to ABN registered retail or landscaping businesses.', '<p>Wholesale only.&nbsp; Our ferns and other potted plants are only available to ABN registered retail or landscaping businesses.</p>', NULL, 'ferns', 'Wholesale only.  Our ferns and other potted plants are only available to ABN registered retail or landscaping businesses.', 'ferns', 'ACTIVE', '2020-09-02 09:55:16', '2020-09-02 09:55:16'),
(3, 1, 'Paulownia', 'Paulownia make a fantastic fast-growing addition to a farm when planted in a small, easily managed grove. They provide shade and fodder, beautiful flowers in spring and can be harvested for timber.\r\n\r\nToad Gully Growers supplied millions of Paulownia seedlings to plantation projects worldwide over 30 years. The motivation was to assist the climate change problem as Paulownia have the potential for rapid growth and carbon sequestration and will regenerate from the stump when harvested for timber. Some projects were successful, but many were not.', '<figure class=\"is-pulled-left is-quarter\"><img title=\"3 year old Paulownia\" src=\"http://localhost/public/storage/pages/September2020/3yr-old-paulownia-min.jpg\" alt=\"3 year old Paulownia\" />\r\n<figcaption>3 year old Paulownia</figcaption>\r\n</figure>\r\n<p>Paulownia make a fantastic fast-growing addition to a farm when planted in a small, easily managed grove. They provide shade and fodder, beautiful flowers in spring and can be harvested for timber.</p>\r\n<p>Toad Gully Growers supplied millions of Paulownia seedlings to plantation projects worldwide over 30 years. The motivation was to assist the climate change problem as Paulownia have the potential for rapid growth and carbon sequestration and will regenerate from the stump when harvested for timber. Some projects were successful, but many were not.</p>\r\n<p>We have come to believe Paulownia are not well matched to corporate forestry. The main reasons for failure have been poor site selection, both in terms of soil type and climatic conditions and poor or insufficient management. Greed has played a large part. Often investors have been duped into funding plantations, but insufficient funding has been put into the plantation management and rather has gone to those running the schemes.</p>\r\n<p>Paulownia is a deciduous tree from east Asia, predominately China. The regions Paulownia grow in naturally have good summer rainfall and generally drier cold winter months. This means there are limited regions in Australia suited to the growth of Paulownia.&nbsp;</p>\r\n<p>Paulownia require freely draining fertile soil. They have the potential for amazingly fast growth under the correct conditions but need a lot of water and nutrition during spring to autumn to achieve this fast growth. They are prone to fatal root rot if the water level rises above 1m for more than 3 days, especially in a wet winter when they are dormant, so the soil should be mounded if it is not naturally well drained. Under preferable care, Paulownia grow almost fast enough to watch, so you are quickly rewarded for your efforts!</p>\r\n<p>Toad Gully Growers supply Paulownia Headstarters&trade;, small bare root plants, during spring and summer. Headstarters&trade; are bare-root Paulownia trees with trimmed trunks. They are ready to plant in the ground and will regenerate a new trunk rapidly with warm weather and correct management.</p>\r\n<p>Headstarters&trade; have well-developed roots systems about the size of a large hand. These roots have a framework of thick fleshy main roots which contain the energy the tree needs to quickly regenerate in the field. The trunks are trimmed just above a strong node usually at about 150mm tall. They have many reserve buds, ready to sprout, ensuring a new trunk will develop even if some of the buds are damaged - for example by adverse weather.</p>\r\n<p>To grow Paulownia successfully you need to:</p>\r\n<ul>\r\n<li>Avoid planting during periods of extreme temperatures</li>\r\n<li>Plant only in very free draining soil &ndash; poorly drained sites need raised beds and drains</li>\r\n<li>Provide them with weed free conditions &ndash; at least for establishment</li>\r\n<li>Feed them well &ndash; to grow fast they have high fertiliser requirements</li>\r\n<li>Water well during summer but let soil dry a little before next watering (30L min per tree to start, later 100L+ but less often)</li>\r\n<li>If growing for timber they usually require some pruning to obtain clear wood</li>\r\n</ul>\r\n<h3>Spacing</h3>\r\n<p>If you are growing Paulownia for timber it is important they are not over-crowded. The maximum planting density for a clear fell harvest without thinning is 400 trees per hectare (161 per acre). This can be planted 5 x 5m or 4m in row with the rows 6.25m apart. The latter will save costs on cultivation, dripper line and maintenance works. If you can afford the space planting them wider is better &ndash; the figures given here are the closest we suggest you can plant and achieve good results under ideal conditions.</p>\r\n<p>Ornamental planting can be done at various spacing depending on the effect you want. TGG suggest a single row can be planted as close as 2m apart if you want a hedging effect or 4 metres apart for a more stately look. A double row can be planted 3m apart in a zigzag pattern or as wide as 7m apart if you want a lot of light distribution through the canopy. Paulownia will not compete well if planted within 12m of a vigorous tree like pine or eucalypt. We do not recommend planting within 6m from a structure.</p>\r\n<h2>Please follow this growing guide:</h2>\r\n<h3>1) Unpacking The Bags</h3>\r\n<p>The Headstarters&trade; can be left in the plastic bags in a cool dark place for a matter of only a few days. DO NOT LEAVE IN THE BAGS IN A WARM PLACE as the plants may rot. They ideally should be unpacked and planted within 48 hours of delivery.</p>\r\n<h3>2) Holding Before Planting</h3>\r\n<p>If you must store them, remove the plants from the plastic bags as soon as possible and immediately place them upright with their roots covered with potting mix or similar medium in a SUNNY position and keep them moist BUT NOT WET. Under these conditions they will begin to grow, so should not be held any longer than absolutely necessary as if they become too active before planting they are at a greater risk of transplant shock when planted out and may suffer wind damage if they have tall soft growth</p>\r\n<h3>3) Planting Out&nbsp;</h3>\r\n<p>Carry the Headstarters&trade; in a way that keeps them bunched together, cool and moist, and plant them into well cultivated, friable, moist soil. If prone to waterlogging the soil should be cultivated into high mounded beds - at least 60cm higher than original soil level. The roots of the Headstarters&trade; should not be disturbed. Make sure the general mass of the roots is pointing downwards and the shallowest root is covered by 3cm of soil. Gently firm the soil around the trunk.</p>\r\n<h3>4) Fertiliser And Watering</h3>\r\n<p>Exact fertiliser requirements depend on soil type and climate conditions, but as a guide Osmocote 9kg All Purpose Landscape Fertiliser at a rate of 250g (one cup) per tree is a good start. Sprinkle it evenly within a 30cm radius from the trunk. Further application may be needed during the season; the trees should be rich dark green and growth rapid during warm weather. This is a slow release fertiliser designed to last about 6 months. It may take time to begin to release so we suggest you water them in with a liquid fertiliser such as Seasol PowerFeed to help give an initial growth stimulus. Over time, once the trees have dinner plate sized leaves (probably in 6-8 weeks) you could add additional fertiliser to hurry their growth. Pelletised poultry manure such as Dynamic Lifter or Rooster Booster at 1 kg per tree will help them develop larger greener leaves. These act as the solar panels for the young tree, catching the sun\'s rays and converting the energy into fast growth. At this time, the trees will need to be kept well-watered too as this is when they use a lot of water for the fast growth stage. However, to begin, for the first few weeks after planting, they do not want too much water. They only need the ground to be moist, not wet. Only water heavily once the heat arrives and the trees have very large leaves.</p>\r\n<h3>5) Trunk Regeneration&nbsp;</h3>\r\n<p>When the weather is warm the trunk will regenerate from the Headstarters&trade; stump. (However even if it&rsquo;s warm it generally takes 3 to 6 weeks to sprout, so don&rsquo;t panic.) Often multiple stems sprout from the many reserve buds on Headstarters&trade;; only the strongest one should be allowed to grow. The best shoots usually grow from low on the stump. Wait until the best trunk shoots are at least 20cm tall, then trim off all but one strong one and remove any portion of the original trunk above the shoot you have selected. This shoot will then grow more strongly and straight, to become the new trunk. Headstarters&trade; planted in spring and given ideal conditions, may reach between 2 to 4 metres by autumn!</p>\r\n<h3>6) Pruning</h3>\r\n<p>Paulownia can be shaped into tall, stately trees or shorter bushy specimens depending on what you want. The removal of the tips of the branches and even the top portion of the trunk, will force regrowth lower on the stems to produce a dense, compact tree. Multi-trunked bushy trees can be continuously pruned for fodder throughout the growing season. Timber growers will want a tall straight trunk and should gradually lift prune any branches that grow on the first 4 to 6m being sure to always leave at least one third of the height of the trunk covered with leaved branches. It is usually a simple matter of removing the lower branches (generally from late summer to early winter) when they reach 2 to 3 cm diameter. This should prevent large knots in the timber. Be sure not to mistake the thick leaf stalks in the first season for branches! You should not remove the big leaves as this will slow growth. They will drop naturally by mid-winter leaving behind a pattern on the trunk which does not impact the timber.</p>\r\n<h3>7) Problems, Queries, Comment Suggestions</h3>\r\n<p>Contact us, preferably using our contact form. We hope you enjoy growing Toad Gully Growers Paulownia Headstarters&trade;.</p>', NULL, 'paulownia', 'Paulownia make a fantastic fast-growing addition to a farm when planted in a small, easily managed grove. They provide shade and fodder, beautiful flowers in spring and can be harvested for timber.', 'Paulownia', 'ACTIVE', '2020-09-02 09:57:26', '2020-09-18 05:08:39'),
(4, 1, 'Contact Us', 'VISIT BY APPOINTMENT ONLY Important: We no longer accept international orders.', '<p><strong>VISIT BY APPOINTMENT ONLY</strong></p>\r\n<p>&nbsp;</p>\r\n<p>Important: We no longer accept international orders.</p>\r\n<p>&nbsp;</p>\r\n<p>Toad Gully Growers</p>\r\n<p>361 Stumpy Gully Rd</p>\r\n<p>Balnarring Vic, 3926</p>\r\n<p>&nbsp;</p>\r\n<p>ABN 61 173 928 602</p>\r\n<p>&nbsp;</p>\r\n<p>tel 03 5983 5688</p>\r\n<p>8:00am - 5:00pm Monday to Friday Melbourne time</p>\r\n<p>&nbsp;</p>', 'testing/headstarters.jpg', 'contact-us', 'Contact us', 'contact', 'ACTIVE', '2020-09-02 09:59:31', '2020-09-24 01:22:15'),
(5, 1, 'Products', 'Sales within Australia only.\r\n\r\nWe are unable to supply Tasmania or Western Australia.', '<article class=\"message is-warning\">\r\n<div class=\"message-body\">\r\n<p>Sales within Australia only.</p>\r\n<p><em>We are unable to supply Tasmania or Western Australia.</em></p>\r\n<p><em>&nbsp;</em></p>\r\n</div>\r\n</article>\r\n<p>All prices include GST and delivery (to all states except Tas &amp; WA).</p>\r\n<p>Growing information is available on the Paulownia page.</p>', NULL, 'products', 'Products', 'prdoucats', 'ACTIVE', '2020-09-02 10:01:48', '2020-09-08 02:40:20'),
(6, 1, 'Cart', 'cart', NULL, 'pages/September2020/6w24uf10RCHI02wOoiUx.jpg', 'cart', 'cart', 'cart', 'ACTIVE', '2020-09-02 10:03:05', '2020-09-18 00:56:15'),
(7, 1, 'Checkout', 'Checkout', '<p>Checkout</p>', 'pages/September2020/AHTgDsJtpbJVraCtQeDs.jpg', 'checkout', 'checkout', 'checkout', 'ACTIVE', '2020-09-05 14:24:15', '2020-09-18 01:02:14'),
(8, 1, 'Thankyou', 'Thank you', '<p>Thank you</p>', NULL, 'thankyou', 'thankyou', 'thankyou', 'ACTIVE', '2020-09-05 14:54:26', '2020-09-05 14:54:26');

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
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `table_name`, `created_at`, `updated_at`) VALUES
(1, 'browse_admin', NULL, '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(2, 'browse_bread', NULL, '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(3, 'browse_database', NULL, '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(4, 'browse_media', NULL, '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(5, 'browse_compass', NULL, '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(6, 'browse_menus', 'menus', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(7, 'read_menus', 'menus', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(8, 'edit_menus', 'menus', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(9, 'add_menus', 'menus', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(10, 'delete_menus', 'menus', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(11, 'browse_roles', 'roles', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(12, 'read_roles', 'roles', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(13, 'edit_roles', 'roles', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(14, 'add_roles', 'roles', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(15, 'delete_roles', 'roles', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(16, 'browse_users', 'users', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(17, 'read_users', 'users', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(18, 'edit_users', 'users', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(19, 'add_users', 'users', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(20, 'delete_users', 'users', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(21, 'browse_settings', 'settings', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(22, 'read_settings', 'settings', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(23, 'edit_settings', 'settings', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(24, 'add_settings', 'settings', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(25, 'delete_settings', 'settings', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(26, 'browse_categories', 'categories', '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(27, 'read_categories', 'categories', '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(28, 'edit_categories', 'categories', '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(29, 'add_categories', 'categories', '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(30, 'delete_categories', 'categories', '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(31, 'browse_posts', 'posts', '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(32, 'read_posts', 'posts', '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(33, 'edit_posts', 'posts', '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(34, 'add_posts', 'posts', '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(35, 'delete_posts', 'posts', '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(36, 'browse_pages', 'pages', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(37, 'read_pages', 'pages', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(38, 'edit_pages', 'pages', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(39, 'add_pages', 'pages', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(40, 'delete_pages', 'pages', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(41, 'browse_hooks', NULL, '2020-09-11 05:27:55', '2020-09-11 05:27:55'),
(42, 'browse_plants', 'plants', '2020-09-13 04:59:06', '2020-09-13 04:59:06'),
(43, 'read_plants', 'plants', '2020-09-13 04:59:06', '2020-09-13 04:59:06'),
(44, 'edit_plants', 'plants', '2020-09-13 04:59:06', '2020-09-13 04:59:06'),
(45, 'add_plants', 'plants', '2020-09-13 04:59:06', '2020-09-13 04:59:06'),
(46, 'delete_plants', 'plants', '2020-09-13 04:59:06', '2020-09-13 04:59:06'),
(47, 'browse_plant_categories', 'plant_categories', '2020-09-13 05:00:05', '2020-09-13 05:00:05'),
(48, 'read_plant_categories', 'plant_categories', '2020-09-13 05:00:05', '2020-09-13 05:00:05'),
(49, 'edit_plant_categories', 'plant_categories', '2020-09-13 05:00:05', '2020-09-13 05:00:05'),
(50, 'add_plant_categories', 'plant_categories', '2020-09-13 05:00:05', '2020-09-13 05:00:05'),
(51, 'delete_plant_categories', 'plant_categories', '2020-09-13 05:00:05', '2020-09-13 05:00:05'),
(52, 'browse_orders', 'orders', '2020-09-18 03:22:02', '2020-09-18 03:22:02'),
(53, 'read_orders', 'orders', '2020-09-18 03:22:02', '2020-09-18 03:22:02'),
(54, 'edit_orders', 'orders', '2020-09-18 03:22:02', '2020-09-18 03:22:02'),
(55, 'add_orders', 'orders', '2020-09-18 03:22:02', '2020-09-18 03:22:02'),
(56, 'delete_orders', 'orders', '2020-09-18 03:22:02', '2020-09-18 03:22:02'),
(57, 'browse_order_statuses', 'order_statuses', '2020-09-18 03:25:49', '2020-09-18 03:25:49'),
(58, 'read_order_statuses', 'order_statuses', '2020-09-18 03:25:49', '2020-09-18 03:25:49'),
(59, 'edit_order_statuses', 'order_statuses', '2020-09-18 03:25:49', '2020-09-18 03:25:49'),
(60, 'add_order_statuses', 'order_statuses', '2020-09-18 03:25:49', '2020-09-18 03:25:49'),
(61, 'delete_order_statuses', 'order_statuses', '2020-09-18 03:25:49', '2020-09-18 03:25:49');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
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
(61, 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plants`
--

CREATE TABLE `plants` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `botanical_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `published` tinyint(1) DEFAULT NULL,
  `promoted` tinyint(1) DEFAULT NULL,
  `plantcategory_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plants`
--

INSERT INTO `plants` (`id`, `title`, `botanical_name`, `image`, `description`, `published`, `promoted`, `plantcategory_id`, `created_at`, `updated_at`) VALUES
(1, 'Maidenhair Fern', 'Adiantum raddianum \'Fragrans\'', 'plants/September2020/LlUMiGh8JTNsHKvNRDsz.jpg', '<p>Graceful indoor, patio or understory garden plant. Protect from direct sun, drying winds &amp; keep moist</p>', 1, 0, 1, NULL, '2020-09-14 01:00:30'),
(2, 'Pacific Maid Maidenhair Fern', 'Adiantum raddianum \'Pacific Maid\'', 'plants/September2020/vZPW2gLJGzNtN6tMqybC.jpg', '<p>Graceful indoor, patio or understory garden plant. Protect from direct sun, drying winds &amp; keep moist.</p>', 1, 0, 1, NULL, '2020-09-14 01:05:34'),
(23, 'Upside-Down Fern', 'Arachnoides standishii', 'plants/September2020/0dIyCxQMt8xz9oEyWhLw.jpg', '<p>Hardy Japanese woodland fern. Thinly textured fronds show the spores underside, hence the name.</p>', 1, 0, 1, NULL, '2020-09-17 01:21:40'),
(24, 'Shredded Spleenwort', 'Asplenium aethiopicum', 'plants/September2020/vD7oX4uvWzJXxIWVvkGp.jpg', '<p>Grows on or amongst rocks in the Aussie bush. Tough fronds to 40cm. Indoor or shady garden.</p>', 1, 0, 1, NULL, '2020-09-17 01:23:41'),
(25, 'Bird\'s Nest Fern', 'Asplenium australasicum', 'plants/September2020/Ke8rass5v2Lr2IzuoXBR.jpg', '<p>Robust Australian fern to 2m. Indoor, well-drained garden or as epiphyte on tree or rock. Light shade.</p>', 1, 0, 1, NULL, '2020-09-17 01:24:18'),
(26, 'Hen And Chicken Fern', 'Asplenium bulbiferum', 'plants/September2020/ZF8fEycJcfsGesiHymo2.jpg', '<p>Delicate looking but easy and adaptable. Indoor or shady garden. Grows baby ferns on fronds to 1.2m.</p>', 1, 0, 1, NULL, '2020-09-17 01:25:07'),
(27, 'Island Beauty', 'Asplenium bulbiferum x surrogatum', 'plants/September2020/dGNOqJoSmB0uUslMHvn4.jpg', '<p>Resilient fern with glossy tough fronds to 75cm. Shady garden or great indoors out of direct sun.</p>', 1, 0, 1, NULL, '2020-09-17 01:25:48'),
(28, 'Island Jewel', 'Asplenium milnei', 'plants/September2020/YGYpYOu2najOWvmsdkB2.jpg', '<p>Shiny easy to grow fern from lowland Lord Howe Is. Clump of fronds to 60cm. Indoors or shady garden.</p>', 1, 0, 1, NULL, '2020-09-17 01:26:38'),
(29, 'Bird\'s Nest Fern', 'Asplenium nidus', 'plants/September2020/nRQPLXD1NHMtHK4ZtIvK.jpg', '<p>Strong Aussie fern to 1.5m. Indoor, well drained shady garden or epiphytic on tree or rock.</p>', 1, 0, 1, NULL, '2020-09-17 01:27:26'),
(30, 'Japanese Painted Fern', 'Athyrium niponicum \'Pictum\'', 'plants/September2020/AMc18fbZNXUI3ComZHCk.jpg', '<p>Beautiful silvery grey, red and blue fronds to 50cm. Cold hardy. Likes rich loam in dappled sunlight.</p>', 1, 0, 1, NULL, '2020-09-17 01:28:22'),
(31, 'Japanese Plum Fern', 'Athyrium otophorum', 'plants/September2020/MoH3ejEt1KHIkzJQ3K05.jpg', '<p>Decorative fern with wine red stems on fronds to 70cm. Likes rich loam in dappled sunlight.</p>', 1, 0, 1, NULL, '2020-09-17 01:31:11'),
(32, 'Brazilian Volcano Fern', 'Blechnum brasiliense', 'plants/September2020/tXXw8aMhZWZ0pUD9E62A.jpg', '<p>Lush with red new growth. Fronds to 1.5m. Older plants have short trunk. Pots / moist shady garden.</p>', 1, 0, 1, NULL, '2020-09-17 01:32:07'),
(33, 'Ray Water Fern', 'Blechnum fluviatile', 'plants/September2020/UAMWbhwdu66Zpm2HqUcV.jpg', '<p>Ideal rockery or shady garden plant. Fronds to 50cm in beautiful rosette. Keep well watered.</p>', 1, 0, 1, NULL, '2020-09-17 01:32:53'),
(34, 'Silver Lady Fern', 'Blechnum gibbum \'Silver Lady\'', 'plants/September2020/RP8cMi0x8YQgzYB3TDer.jpg', '<p>Lush but easy care. Fronds to 70cm. Older plants have short trunk. Pots or moist shady garden.</p>', 1, 0, 1, NULL, '2020-09-17 01:33:49'),
(35, 'Opal Fern', 'Blechnum minus x wattsii', 'plants/September2020/JF67579VwHEPore97RCg.jpg', '<p>Cold hardy Aussie. Bronze-pink new fronds become tough dark green to 1.2m. Shade to sunny if moist.</p>', 1, 0, 1, NULL, '2020-09-17 01:34:52'),
(36, 'Fishbone Water Fern', 'Blechnum nudum', 'plants/September2020/KmYiOZSsI2ziLTTJj15B.jpg', '<p>Aust. Beautiful whether singular in a pot or mass planted in a moist shady garden. Fronds to 1m.</p>', 1, 0, 1, NULL, '2020-09-17 01:35:42'),
(37, 'Alpine Water Fern', 'Blechnum penna-marina', 'plants/September2020/sYvk5sVb96vx2QaGrDx2.jpg', '<p>Delightful creeping ground cover 30cm tall. Shady moist garden. Fast growing, cold tolerant Aussie.</p>', 1, 0, 1, NULL, '2020-09-17 01:36:46'),
(38, 'Binung', 'Christella dentata', 'plants/September2020/oGFojBB8kOmAVI6vOzN2.jpg', '<p>Hardy Aussie fern. Appealing rosette of graceful fronds to 1m. Easily grown in moist location.</p>', 1, 0, 1, NULL, '2020-09-17 01:37:35'),
(39, 'Norfolk Island Tree Fern', 'Cyathea brownii', 'plants/September2020/eSGVoO4adIT0dz7jvg6w.jpg', '<p>Vigorous. Impressive in a moist lightly shaded to sunny garden. Fronds to 4m long, strong tall trunk.</p>', 1, 0, 1, NULL, '2020-09-17 01:38:32'),
(40, 'Lacy Tree Fern', 'Cyathea cooperi \'Improved\'', 'plants/September2020/bDbA599zeMJtB4PNQVjs.jpg', '<p>Fast growing Aussie tree fern. Moist lightly shaded to sunny position. Huge fronds and tall slim trunk.</p>', 1, 0, 1, NULL, '2020-09-17 01:39:46'),
(41, 'Island Pride', 'Cyathea robusta', 'plants/September2020/dtiOWP6ZneUeJHFkYt2B.jpg', '<p>Strong tree fern from Lord Howe Is. Broad fronds to 2m long, trunk to 5m. Easy to grow in moist shade.</p>', 1, 0, 1, NULL, '2020-09-17 01:40:52'),
(42, 'Soft Tree Fern', 'Dicksonia antarctica', 'plants/September2020/stpUNFmqEZ6gePTV6uui.jpg', '<p>Hardy Aussie fern. Can grow huge with fronds 3m long on thick tall trunk. Moist shady to partial sun.</p>', 1, 0, 1, NULL, '2020-09-17 01:44:24'),
(43, 'Prickly Rasp Fern', 'Doodia aspera', 'plants/September2020/ut4M9VWe5JNHCxF2GZlK.jpg', '<p>Tough Aussie. New fronds bright pink to red growing to 35cm. Shady to moist sunny garden.</p>', 1, 0, 1, NULL, '2020-09-17 01:45:10'),
(44, 'Rasp Fern', 'Doodia media', 'plants/September2020/M2KwfqAIIxKMEIk9MuTJ.jpg', '<p>Hardy Aussie. Tough fronds to 30cm. Red new growth. Great ground cover. Moist, semi shade.</p>', 1, 0, 1, NULL, '2020-09-17 01:46:05'),
(45, 'Golden-Scaled Male Fern', 'Dryopteris affinis \'Cristata The King\'', 'plants/September2020/m1aBHVcNOwwa3IIoThfd.jpg', '<p>This fancy fern was developed in the Victorian age. Fronds to 1.2m. Easily grown in moist shade. UK.</p>', 1, 0, 1, NULL, '2020-09-17 01:46:53'),
(46, 'Broad Buckler Fern', 'Dryopteris dilatata \'Crispa Whiteside\'', 'plants/September2020/J8kdYxO8ofwNEk5ajpgJ.jpg', '<p>This form has frilly crested fronds to over 1m. Easily grown in moist garden. Shade to partial sun.</p>', 1, 0, 1, NULL, '2020-09-17 01:47:47'),
(47, 'Autumn Fern', 'Dryopteris erythrosora', 'plants/September2020/kA8NPJtRMwU5EcQqjClR.jpg', '<p>Coppery to red new fronds, older dark green, 45cm. Easy to grow in deep shade to part sun. East Asia.</p>', 1, 0, 1, NULL, '2020-09-17 01:48:41'),
(48, 'Male Fern', 'Dryopteris filix-mas', 'plants/September2020/ASfZyPQtFUh043emKUPk.jpg', '<p>Widespread northern hemisphere favourite due to dramatic 1.5m fronds. Easy in moist semi-shade.</p>', 1, 0, 1, NULL, '2020-09-17 01:49:38'),
(49, 'Marginal Woodfern', 'Dryopteris marginalis', 'plants/September2020/IvVfBOLePlrrSOMl1IVF.jpg', '<p>Clumps of tough fronds to 60cm. Easy to grow in loamy soil under the shade of trees. Nth America.</p>', 1, 0, 1, NULL, '2020-09-17 01:50:48'),
(50, 'Kangaroo Fern', 'Microsorum diversifolium', 'plants/September2020/i6wfBtBfsAdRx5Kw2LwT.jpg', '<p>Tough Aussie. Grows on trees, rocks or in ground, pots or baskets. Plastic-like fronds to 60cm.</p>', 1, 0, 1, NULL, '2020-09-17 01:51:52'),
(51, 'Emerald Queen', 'Nephrolepis obliterata \'Emerald Queen\'', 'plants/September2020/kcIrjdMvPM8KPCfeyPDg.jpg', '<p>Easy to grow Aussie. Ideal for hanging basket, tub or garden. Great indoors, patio or shady corner.</p>', 1, 0, 1, NULL, '2020-09-17 01:53:10'),
(52, 'Royal Fern', 'Osmunda regalis', 'plants/September2020/wftSYrFvwu00VgYsr4wD.jpg', '<p>Majestic clumping fern ideally suited to wet areas where the fronds may grow to 3m. Very cold hardy.</p>', 1, 0, 1, NULL, '2020-09-17 01:54:31'),
(53, 'Feather Shield Fern', 'Polystichum retrosopaleaceum', 'plants/September2020/M70EoGMvRotivbqm7Ngv.jpg', '<p>Hardy. Shiny fronds to 1m. Moist garden or tub in shade. Interesting flushes of new growth. Japan.</p>', 1, 0, 1, NULL, '2020-09-17 01:56:13'),
(54, 'Cretan Brake', 'Pteris cretica \'Gautherii\'', 'plants/September2020/7oCDiK8oQKQNuYKZEXNY.jpg', '<p>Easy to grow in a pot or moist free draining soil. Best in dappled sunlight. Frilly fronds to 60cm.</p>', 1, 0, 1, NULL, '2020-09-17 01:57:21'),
(55, 'Graceful Jungle Brake', 'Pteris umbrosa var. gracilifolia', 'plants/September2020/4n5AN2nz9Kc52WywuVvk.jpg', '<p>Australian rainforest fern. Easy to grow in shady moist garden. Shiny narrow dark green fronds, 1m.</p>', 1, 0, 1, NULL, '2020-09-17 01:58:37'),
(56, 'Leather Fern', 'Rumohra adiantiformis Cape form', 'plants/September2020/lb5ZFNCvuCJfpIzSIu6V.jpg', '<p>Vigorous South African fern with thick tough fronds to 1.5m. Ideal indoor, garden, cut foliage.</p>', 1, 0, 1, NULL, '2020-09-17 02:00:34'),
(57, 'Emerald Clubmoss', 'Selaginella kraussiana', 'plants/September2020/go8r5GRdge1vZu4qj31l.jpg', '<p>Soft low groundcover ideal for moist fernery, terrarium, pot or basket. Indoor or shady garden.</p>', 1, 0, 1, NULL, '2020-09-17 02:04:21'),
(58, 'Golden Clubmoss', 'Selaginella kraussiana \'Aurea\'', 'plants/September2020/jaLSQ1rOy0UaMqP4W2Xr.jpg', '<p>Soft low groundcover ideal for moist fernery, terrarium, pot or basket. Indoor or shady garden.</p>', 1, 0, 1, NULL, '2020-09-18 03:58:35'),
(59, 'Baby\'s Tears', 'Soleirolia soleirolii', 'plants/September2020/hujkeoUtiqE8q33P4dwc.jpg', '<p>Easy to grow living carpet for a shady fernery. Also great for baskets, terrariums &amp; walls. Keep moist.</p>', 1, 0, 1, NULL, '2020-09-17 02:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `plant_categories`
--

CREATE TABLE `plant_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `published` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plant_categories`
--

INSERT INTO `plant_categories` (`id`, `title`, `slug`, `description`, `published`, `created_at`, `updated_at`) VALUES
(1, 'Ferns', 'ferns', NULL, 1, NULL, NULL),
(2, 'Paulownia', 'paulownia', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int UNSIGNED NOT NULL,
  `author_id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('PUBLISHED','DRAFT','PENDING') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DRAFT',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `category_id`, `title`, `seo_title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `featured`, `created_at`, `updated_at`) VALUES
(1, 0, NULL, 'Lorem Ipsum Post', NULL, 'This is the excerpt for the Lorem Ipsum Post', '<p>This is the body of the lorem ipsum post</p>', 'posts/post1.jpg', 'lorem-ipsum-post', 'This is the meta description', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(2, 0, NULL, 'My Sample Post', NULL, 'This is the excerpt for the sample Post', '<p>This is the body for the sample post, which includes the body.</p>\n                <h2>We can use all kinds of format!</h2>\n                <p>And include a bunch of other stuff.</p>', 'posts/post2.jpg', 'my-sample-post', 'Meta Description for sample post', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(3, 0, NULL, 'Latest Post', NULL, 'This is the excerpt for the latest post', '<p>This is the body for the latest post</p>', 'posts/post3.jpg', 'latest-post', 'This is the meta description', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(4, 0, NULL, 'Yarr Post', NULL, 'Reef sails nipperkin bring a spring upon her cable coffer jury mast spike marooned Pieces of Eight poop deck pillage. Clipper driver coxswain galleon hempen halter come about pressgang gangplank boatswain swing the lead. Nipperkin yard skysail swab lanyard Blimey bilge water ho quarter Buccaneer.', '<p>Swab deadlights Buccaneer fire ship square-rigged dance the hempen jig weigh anchor cackle fruit grog furl. Crack Jennys tea cup chase guns pressgang hearties spirits hogshead Gold Road six pounders fathom measured fer yer chains. Main sheet provost come about trysail barkadeer crimp scuttle mizzenmast brig plunder.</p>\n<p>Mizzen league keelhaul galleon tender cog chase Barbary Coast doubloon crack Jennys tea cup. Blow the man down lugsail fire ship pinnace cackle fruit line warp Admiral of the Black strike colors doubloon. Tackle Jack Ketch come about crimp rum draft scuppers run a shot across the bow haul wind maroon.</p>\n<p>Interloper heave down list driver pressgang holystone scuppers tackle scallywag bilged on her anchor. Jack Tar interloper draught grapple mizzenmast hulk knave cable transom hogshead. Gaff pillage to go on account grog aft chase guns piracy yardarm knave clap of thunder.</p>', 'posts/post4.jpg', 'yarr-post', 'this be a meta descript', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2020-09-11 05:27:53', '2020-09-11 05:27:53');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `published` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `code`, `image`, `description`, `published`, `created_at`, `updated_at`) VALUES
(1, 'Paulownia fortunei Guangdong Select', 'paulownia-fortunei-guangdong-select', 'PF-GS01', NULL, '<p>Paulownia fortunei is favoured for its ability to produce a straight trunk more readily than some other species and its adaptability to Australian climatic conditions. Derived from a Guangdong China seed orchard and further developed by TGG in Australia. TGG have supplied this variety to plantations in climatic regions ranging from wet tropics, temperate to hot arid with positive results. (Although it must be said all Paulownia need a lot of irrigation in hot dry zones.) Early growth is steady during establishment, but this strain puts on a growth spurt in year 3 followed by consistent increment each year with good trunk form for timber production. In spring the pyramid form mature trees are decorated with spectacular large pale purple to cream with yellow and dark purple interior, trumpet shaped flowers. Once the flowers are finished a leafy canopy emerges. Fantastic shade or parkland feature trees.</p>', 1, NULL, '2020-10-05 12:13:40');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', '2020-09-11 05:27:50', '2020-09-11 05:27:50'),
(2, 'user', 'Normal User', '2020-09-11 05:27:50', '2020-09-11 05:27:50');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('HlFzaPISQADFPRBoB0r80RxZQyqbSyUIY8bUFZUQ', NULL, '172.22.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:81.0) Gecko/20100101 Firefox/81.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOTJpdVRzZktqZ0h2ZkwxVlU5RFlTMVViWVhhR2lSRXpwazdCNlVzZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3QvYmFja2VuZC9ibG9ja3MvY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1602911515),
('rJVB7Lb6MpSvMnTBvMsFUIoctYNaTz5F2Vlt2gZo', 1, '172.22.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:81.0) Gecko/20100101 Firefox/81.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNTZIODRBTkdMQTFQOVRhdXowdHFjOWFzd2RRTzNyYzJKNGE1T01vUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3QvYmFja2VuZC9ibG9ja3MvY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJFdINjUvYndQYVc4dEpBbnREUW9vSi5UeHlyNmZyU3lHUlN2bGZuTWh6VG1HTmdxdW1yOWpDIjt9', 1602912476),
('WEnziSh0WoZ181rX3YugGQJ60bBLZnbQD7Q0q7GE', NULL, '172.22.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:81.0) Gecko/20100101 Firefox/81.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMnF3Tmg2eFJ6aElQeXNxcUtjaldYRFNqUGNmdERYN2lMclhXQ1VLVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3QvYmFja2VuZC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1602911516),
('WgXysGnjjm8eJgPmG6wJ6xEV8ynPRkl92khQuSZA', 1, '172.22.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.80 Safari/537.36 Edg/86.0.622.43', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWWtQQlhLWU5helpwUWJUT0J1czFZQkYxaWV2ZFFENVVGdkNHZG5TcCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJFdINjUvYndQYVc4dEpBbnREUW9vSi5UeHlyNmZyU3lHUlN2bGZuTWh6VG1HTmdxdW1yOWpDIjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozODoiaHR0cDovL2xvY2FsaG9zdC9iYWNrZW5kL2Jsb2Nrcy9jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1603005679);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `details` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '1',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `display_name`, `value`, `details`, `type`, `order`, `group`) VALUES
(1, 'site.title', 'Site Title', 'Site Title', '', 'text', 1, 'Site'),
(2, 'site.description', 'Site Description', 'Site Description', '', 'text', 2, 'Site'),
(3, 'site.logo', 'Site Logo', '', '', 'image', 3, 'Site'),
(4, 'site.google_analytics_tracking_id', 'Google Analytics Tracking ID', '', '', 'text', 4, 'Site'),
(5, 'admin.bg_image', 'Admin Background Image', '', '', 'image', 5, 'Admin'),
(6, 'admin.title', 'Admin Title', 'Voyager', '', 'text', 1, 'Admin'),
(7, 'admin.description', 'Admin Description', 'Welcome to Voyager. The Missing Admin for Laravel', '', 'text', 2, 'Admin'),
(8, 'admin.loader', 'Admin Loader', '', '', 'image', 3, 'Admin'),
(9, 'admin.icon_image', 'Admin Icon Image', '', '', 'image', 4, 'Admin'),
(10, 'admin.google_analytics_client_id', 'Google Analytics Client ID (used for admin dashboard)', '', '', 'text', 1, 'Admin');

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
-- Table structure for table `textcolours`
--

CREATE TABLE `textcolours` (
  `id` bigint UNSIGNED NOT NULL,
  `background` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `css` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `textcolours`
--

INSERT INTO `textcolours` (`id`, `background`, `css`, `created_at`, `updated_at`) VALUES
(1, 'has-background-black', 'has-text-white', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(2, 'has-background-white', 'has-text-black', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(3, 'has-background-white', 'has-text-dark-green', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(4, 'has-background-black', 'has-text-light-green', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(5, 'has-background-black', 'has-text-tgg-accent1', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(6, 'has-background-black', 'has-text-tgg-accent2', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(7, 'has-background-black', 'has-text-off-white', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(8, 'has-background-black', 'has-text-slate-grey', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(9, 'has-background-white', 'has-text-trans-dark', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(10, 'has-background-black', 'has-text-trans-light', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(11, 'has-background-white', 'has-text-dark', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(12, 'has-background-white', 'has-text-primary', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(13, 'has-background-white', 'has-text-link', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(14, 'has-background-white', 'has-text-info', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(15, 'has-background-white', 'has-text-success', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(16, 'has-background-white', 'has-text-warning', '2020-10-18 06:55:11', '2020-10-18 06:55:11'),
(17, 'has-background-white', 'has-text-danger', '2020-10-18 06:55:11', '2020-10-18 06:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` int UNSIGNED NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int UNSIGNED NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `table_name`, `column_name`, `foreign_key`, `locale`, `value`, `created_at`, `updated_at`) VALUES
(1, 'data_types', 'display_name_singular', 5, 'pt', 'Post', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(2, 'data_types', 'display_name_singular', 6, 'pt', 'Página', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(3, 'data_types', 'display_name_singular', 1, 'pt', 'Utilizador', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(4, 'data_types', 'display_name_singular', 4, 'pt', 'Categoria', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(5, 'data_types', 'display_name_singular', 2, 'pt', 'Menu', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(6, 'data_types', 'display_name_singular', 3, 'pt', 'Função', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(7, 'data_types', 'display_name_plural', 5, 'pt', 'Posts', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(8, 'data_types', 'display_name_plural', 6, 'pt', 'Páginas', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(9, 'data_types', 'display_name_plural', 1, 'pt', 'Utilizadores', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(10, 'data_types', 'display_name_plural', 4, 'pt', 'Categorias', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(11, 'data_types', 'display_name_plural', 2, 'pt', 'Menus', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(12, 'data_types', 'display_name_plural', 3, 'pt', 'Funções', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(13, 'categories', 'slug', 1, 'pt', 'categoria-1', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(14, 'categories', 'name', 1, 'pt', 'Categoria 1', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(15, 'categories', 'slug', 2, 'pt', 'categoria-2', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(16, 'categories', 'name', 2, 'pt', 'Categoria 2', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(17, 'pages', 'title', 1, 'pt', 'Olá Mundo', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(18, 'pages', 'slug', 1, 'pt', 'ola-mundo', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(19, 'pages', 'body', 1, 'pt', '<p>Olá Mundo. Scallywag grog swab Cat o\'nine tails scuttle rigging hardtack cable nipper Yellow Jack. Handsomely spirits knave lad killick landlubber or just lubber deadlights chantey pinnace crack Jennys tea cup. Provost long clothes black spot Yellow Jack bilged on her anchor league lateen sail case shot lee tackle.</p>\r\n<p>Ballast spirits fluke topmast me quarterdeck schooner landlubber or just lubber gabion belaying pin. Pinnace stern galleon starboard warp carouser to go on account dance the hempen jig jolly boat measured fer yer chains. Man-of-war fire in the hole nipperkin handsomely doubloon barkadeer Brethren of the Coast gibbet driver squiffy.</p>', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(20, 'menu_items', 'title', 1, 'pt', 'Painel de Controle', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(21, 'menu_items', 'title', 2, 'pt', 'Media', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(22, 'menu_items', 'title', 12, 'pt', 'Publicações', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(23, 'menu_items', 'title', 3, 'pt', 'Utilizadores', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(24, 'menu_items', 'title', 11, 'pt', 'Categorias', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(25, 'menu_items', 'title', 13, 'pt', 'Páginas', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(26, 'menu_items', 'title', 4, 'pt', 'Funções', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(27, 'menu_items', 'title', 5, 'pt', 'Ferramentas', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(28, 'menu_items', 'title', 6, 'pt', 'Menus', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(29, 'menu_items', 'title', 7, 'pt', 'Base de dados', '2020-09-11 05:27:54', '2020-09-11 05:27:54'),
(30, 'menu_items', 'title', 10, 'pt', 'Configurações', '2020-09-11 05:27:54', '2020-09-11 05:27:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `settings`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'admin@admin.com', 'users/default.png', NULL, '$2y$10$WH65/bwPaW8tJAntDQooJ.Txyr6frSyGRSvlfnMhzTmGNgqumr9jC', NULL, NULL, 'ozmACqY3kplIbxBxclutmmowFDT69wSc2VweWLkWSh2dnh2lx9fdk2DBQ769', NULL, '2020-09-11 05:27:53', '2020-09-11 05:27:53'),
(2, 1, 'Derek Bell', 'lucid@lucid.com.au', 'users/default.png', NULL, '$2y$10$ylkckQy2pRowT.X0SCjQqOFoYNMBYcOuaEFt2fzVbeDENweRopp0q', NULL, NULL, NULL, '{\"locale\":\"en\"}', '2020-09-18 03:37:18', '2020-09-18 03:37:18'),
(3, 1, 'James Lawrence', 'james@toadgully.com.au', 'users/default.png', NULL, '$2y$10$0Pxt3CLEOa4ZqHk2vexexO4x0Winm9PvD/syT5.80orbe1e5yMx6.', NULL, NULL, NULL, '{\"locale\":\"en\"}', '2020-09-18 03:38:18', '2020-09-18 03:38:18');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variations`
--

INSERT INTO `variations` (`id`, `product_id`, `title`, `slug`, `image`, `description`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 'Homestead Pack', 'homestead-pack', NULL, '<p>5 Paulownia Headstarters&trade;</p>', 67, NULL, '2020-10-05 05:22:41'),
(2, 1, 'Farm Pack', 'farm-pack', NULL, '<p>10 Paulownia Headstarters&trade;</p>', 100, NULL, '2020-10-05 05:37:55'),
(3, 1, 'Estate Pack', 'estate-pack', NULL, '<p>25 Paulownia Headstarters&trade;</p>', 229, NULL, '2020-10-05 05:34:48'),
(4, 1, 'Grove Pack', 'grove-pack', NULL, '50 Paulownia Headstarters™ ', 417, NULL, NULL),
(5, 1, 'Woodland Pack', 'woodland-pack', NULL, '100 Paulownia Headstarters™', 667, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `backgroundcolours`
--
ALTER TABLE `backgroundcolours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plants`
--
ALTER TABLE `plants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plant_categories`
--
ALTER TABLE `plant_categories`
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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- Indexes for table `textcolours`
--
ALTER TABLE `textcolours`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `backgroundcolours`
--
ALTER TABLE `backgroundcolours`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `data_rows`
--
ALTER TABLE `data_rows`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `data_types`
--
ALTER TABLE `data_types`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plants`
--
ALTER TABLE `plants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `plant_categories`
--
ALTER TABLE `plant_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `textcolours`
--
ALTER TABLE `textcolours`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
