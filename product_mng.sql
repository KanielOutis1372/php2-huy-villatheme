-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2023 at 12:03 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `product_mng`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE DATABASE IF NOT EXISTS product_mng;
USE product_mng;

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(794, 'acate2'),
(796, 'cate1'),
(797, 'cate2'),
(798, 'cate3'),
(802, 'cate4'),
(803, 'cate5'),
(804, 'cate6'),
(638, 'Plugins');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `gallery_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`gallery_id`, `product_id`, `image`) VALUES
(3392, 946, '64ddeee1e17d7_banner.jpg'),
(3393, 947, '64ddeee6a2c2b_banner-590x300-1.jpg'),
(3394, 948, '64ddeeeb89a9a_banner-590x300-2.jpg'),
(3395, 949, '64ddeeef5e378_banner-590x300-1.jpg'),
(3396, 950, '64ddeef323392_banner-590x300-1.jpg'),
(3397, 951, '64ddeef7118ae_01_preview-1.jpg'),
(3398, 951, '64ddeef8b9d44_02_preview.jpg'),
(3399, 952, '64ddeefdc7d1c_01_preview.jpg'),
(3400, 953, '64ddef0204198_banner-590x300-2.jpg'),
(3401, 953, '64ddef03267ff_screenshot-1.jpg'),
(3402, 953, '64ddef050c653_screenshot-2.jpg'),
(3403, 953, '64ddef06f0eef_screenshot-3.jpg'),
(3404, 953, '64ddef08a073b_screenshot-4.jpg'),
(3405, 924, '64ddef0c296e0_banner-590x300-1.jpg'),
(3406, 925, '64ddef0fdd244_banner-590x300-3.jpg'),
(3407, 926, '64ddef13a36e6_01_preview.jpg'),
(3408, 926, '64ddef14b2642_02_order_screen.jpg'),
(3409, 926, '64ddef16c95a2_03_search_product.jpg'),
(3410, 926, '64ddef1944037_04_receipt.jpg'),
(3411, 926, '64ddef1b63f48_05_menu.jpg'),
(3412, 926, '64ddef1c7044d_06_hotkey.jpg'),
(3413, 927, '64ddef207388b_01_preview.jpg'),
(3414, 928, '64ddef24139d1_01_preview-1.jpg'),
(3415, 928, '64ddef2557478_02_editor.png'),
(3416, 929, '64ddef2a7e070_01_preview.jpg'),
(3417, 929, '64ddef2bbd613_02_config_shopify_app.jpg'),
(3418, 929, '64ddef2d8da7b_03_config_shopify_website.jpg'),
(3419, 929, '64ddef2fd1418_04_migrate_data.jpg'),
(3420, 930, '64ddef347e82c_banner-590x300-2.jpg'),
(3421, 930, '64ddef35bf864_02_gift.jpg'),
(3422, 931, '64ddef3de6db4_01_preview-5.jpg'),
(3423, 931, '64ddef3f015ff_02_single_product_page.jpg'),
(3424, 931, '64ddef4176db2_03_select_product.jpg'),
(3425, 931, '64ddef432c13a_04_product_edit_page.jpg'),
(3426, 932, '64ddef4773399_01_preview-4.jpg'),
(3427, 932, '64ddef48e6927_02_filter_bar.jpg'),
(3428, 933, '64ddef4d0ed75_01_preview.jpg'),
(3429, 933, '64ddef4e1fb6e_02_offers.jpg'),
(3430, 933, '64ddef50d6e43_03_name_your_price.jpg'),
(3431, 934, '64ddef57ab140_01_preview-2.jpg'),
(3432, 934, '64ddef58f2505_02_list_products.jpg'),
(3433, 934, '64ddef5c4fda4_03_filters.jpg'),
(3434, 934, '64ddef5e0bc01_04_custom_metafield.jpg'),
(3435, 935, '64ddef61c4856_banner-590x300-1.jpg'),
(3436, 936, '64ddef65b1806_banner-590x300-1.jpg'),
(3437, 937, '64ddef6b61a82_01_preview-1.jpg'),
(3438, 937, '64ddef6ca161e_04_product.jpg'),
(3439, 937, '64ddef6eecabd_03_menu.jpg'),
(3440, 937, '64ddef70dfd4d_02_frontend.jpg'),
(3441, 938, '64ddef7557e92_01_preview-3.jpg'),
(3442, 938, '64ddef7798f01_02_product_variation_in_single_product.png'),
(3443, 938, '64ddef842c092_03_variations_swatches_on_shop.png'),
(3444, 939, '64ddef90664e4_01_preview.jpg'),
(3445, 939, '64ddef9284978_02_edit_email.png'),
(3446, 939, '64ddef9611430_03_email_manager.png'),
(3447, 940, '64ddef9c39954_01_preview-2.jpg'),
(3448, 940, '64ddef9dab383_screenshot-1.png'),
(3449, 940, '64ddefa341e92_screenshot-2.png'),
(3450, 940, '64ddefa690fbf_screenshot-6.png'),
(3451, 941, '64ddefabc3227_banner-590x300-1.jpg'),
(3452, 942, '64ddefaf35f92_01_preview-1.jpg'),
(3453, 942, '64ddefb07470f_03_order_bump.jpg'),
(3454, 942, '64ddefb22a2bd_02_upsell.jpg'),
(3455, 943, '64ddefb634ad3_banner-590x300-1.jpg'),
(3456, 970, '64ddefb93d69f_banner-590x300-1.jpg'),
(3457, 970, '64ddefbbb1e2d_02_abandoned_carts.jpg'),
(3458, 970, '64ddefbd79215_03_reports.jpg'),
(3459, 970, '64ddefbff0b24_04_email_template.jpg'),
(3460, 970, '64ddefc27c276_05_settings.jpg'),
(3461, 970, '64ddefc5074a1_06_facebook_setting.jpg'),
(3462, 970, '64ddefc7deba0_07_email_popup_setting.jpg'),
(3463, 971, '64ddefccc83be_01_preview-1.jpg'),
(3464, 971, '64ddefce15c06_03_checkout_on_sidebar.jpg'),
(3465, 971, '64ddefd009e27_02_sidebar_cart.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `sale_price` int(11) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `modified_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `sku`, `title`, `price`, `sale_price`, `featured_image`, `description`, `created_date`, `modified_date`) VALUES
(924, 'exmage-wp-image-links', 'EXMAGE &#8211; WordPress Image Links', 0, 0, '64ddef0c296e0_banner-590x300-1.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(925, 'compe-woocommerce-compare-products', 'COMPE &#8211; WooCommerce Compare Products', 0, 0, '64ddef0fdd244_banner-590x300-3.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(926, 'webpos-point-of-sale-for-woocommerce', 'WebPOS &#8211; WooCommerce POS &#8211; Point of Sale &#8211; Restaurant &#8211; Grocery', 69, 49, '64ddef13a36e6_01_preview.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(927, 'redis-woocommerce-dynamic-pricing-and-discounts', 'REDIS &#8211; WooCommerce Dynamic Pricing and Discounts', 0, 0, '64ddef207388b_01_preview.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(928, 'wpbulky-wordpress-bulk-edit-post-types', 'WPBulky &#8211; WordPress Bulk Edit Post Types', 39, 0, '64ddef24139d1_01_preview-1.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(929, 'w2s-migrate-woocommerce-to-shopify', 'W2S &#8211; Migrate WooCommerce to Shopify', 59, 49, '64ddef2a7e070_01_preview.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(930, 'jagif-woocommerce-free-gift', 'Jagif &#8211; WooCommerce Free Gift', 26, 10, '64ddef347e82c_banner-590x300-2.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(931, 'bopo-woo-product-bundle-builder', 'Bopo &#8211; WooCommerce Product Bundle Builder &#8211; Build Your Own Box', 30, 0, '64ddef3de6db4_01_preview-5.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(932, 'pofily-woocommerce-product-filters', 'Pofily &#8211; WooCommerce Product Filters &#8211;  SEO Product Filter', 30, 0, '64ddef4773399_01_preview-4.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(933, 'catna-woocommerce-name-your-price-and-offers', 'Catna &#8211; WooCommerce Name Your Price and Offers', 20, 0, '64ddef4d0ed75_01_preview.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(934, 'bulky-woocommerce-bulk-edit-products', 'Bulky &#8211; WooCommerce Bulk Edit Products, Orders, Coupons', 39, 30, '64ddef57ab140_01_preview-2.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(935, 'woocommerce-product-pre-orders', 'WooCommerce Product Pre-Orders', 0, 0, '64ddef61c4856_banner-590x300-1.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(936, 'product-size-chart-for-woocommerce', 'WooCommerce Product Size Chart', 0, 0, '64ddef65b1806_banner-590x300-1.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(937, 'woocommerce-facebook-chatbot', 'WooCommerce Chatbot for Messenger &#8211; Sales Channel', 99, 0, '64ddef6b61a82_01_preview-1.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(938, 'woocommerce-product-variations-swatches', 'WooCommerce Product Variations Swatches', 22, 0, '64ddef7557e92_01_preview-3.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(939, 'woocommerce-email-template-customizer', 'WooCommerce Email Template Customizer', 32, 0, '64ddef90664e4_01_preview.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(940, 'aliexpress-dropshipping-and-fulfillment-for-woocommerce', 'ALD &#8211; Aliexpress Dropshipping and Fulfillment for WooCommerce', 49, 28, '64ddef9c39954_01_preview-2.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(941, 'woo-coupon-reminder', 'Coreem &#8211; Coupon Reminder for WooCommerce', 0, 0, '64ddefabc3227_banner-590x300-1.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(942, 'woocommerce-checkout-upsell-funnel', 'WooCommerce Checkout Upsell Funnel &#8211; Order Bump', 30, 0, '64ddefaf35f92_01_preview-1.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(943, 'woo-suggestion-engine', 'WooCommerce Suggestion Engine', 0, 0, '64ddefb634ad3_banner-590x300-1.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(946, 'subre-woocommerce-product-subscription-recurring-payments', 'SUBRE &#8211; WooCommerce Product Subscription &#8211; Recurring Payments', 0, 0, '64ddeee1e17d7_banner.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(947, 'clear-autoptimize-cache-automatically', 'Clear Autoptimize Cache Automatically', 0, 0, '64ddeee6a2c2b_banner-590x300-1.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(948, 'gift4u-woocommerce-gift-cards-all-in-one', 'GIFT4U &#8211; WooCommerce Gift Cards All in One', 0, 0, '64ddeeeb89a9a_banner-590x300-2.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(949, 'epow-extra-product-options-for-woocommerce', 'EPOW &#8211; WooCommerce Custom Product Options', 0, 0, '64ddeeef5e378_banner-590x300-1.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(950, 'fewc-checkout-field-editor-for-woocommerce', 'FEWC &#8211; WooCommerce Extra Checkout Fields', 0, 0, '64ddeef323392_banner-590x300-1.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(951, '9mail-wordpress-email-templates-designer', '9MAIL &#8211; WordPress Email Templates Designer', 32, 15, '64ddeef7118ae_01_preview-1.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(952, 'chinads-taobao-dropshipping-for-woocommerce', 'ChinaDS &#8211; Taobao Dropshipping and Fulfillment for WooCommerce', 0, 0, '64ddeefdc7d1c_01_preview.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(953, 'epoi-wordpress-points-and-rewards', 'EPOI &#8211; WordPress Points and Rewards', 0, 0, '64ddef0204198_banner-590x300-2.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(970, 'woocommerce-abandoned-cart-recovery', 'WooCommerce Abandoned Cart Recovery &#8211; Send Cart Recovery Email Plugin &#8211; SMS &#8211; Messenger', 40, 0, '64ddefb93d69f_banner-590x300-1.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(971, 'woo-cart-all-in-one', 'WooCommerce Cart All In One &#8211; One Click Checkout &#8211; Sticky|Side Cart', 30, 0, '64ddefccc83be_01_preview-1.jpg', 'Hiden!', '2023-08-17', '2023-08-17'),
(1153, 'saddas', 'dsasddasa', 0, 0, '', '', '2023-08-17', '2023-08-17'),
(1154, 'testerror3', 'dasasd', 0, 0, '', '', '2023-08-17', '2023-08-17');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`product_id`, `category_id`) VALUES
(946, 638),
(947, 638),
(948, 638),
(949, 638),
(950, 638),
(951, 638),
(952, 638),
(953, 638),
(924, 638),
(925, 638),
(926, 638),
(927, 638),
(928, 638),
(929, 638),
(930, 638),
(931, 638),
(932, 638),
(933, 638),
(934, 638),
(935, 638),
(936, 638),
(937, 638),
(938, 638),
(939, 638),
(940, 638),
(941, 638),
(942, 638),
(943, 638),
(970, 638),
(971, 638);

-- --------------------------------------------------------

--
-- Table structure for table `product_tag`
--

CREATE TABLE `product_tag` (
  `product_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_tag`
--

INSERT INTO `product_tag` (`product_id`, `tag_id`) VALUES
(946, 5220),
(946, 5221),
(946, 5222),
(946, 5223),
(946, 5224),
(946, 5225),
(946, 5226),
(946, 5227),
(946, 5228),
(946, 5229),
(946, 5230),
(947, 5231),
(947, 5232),
(947, 5233),
(947, 5220),
(947, 5235),
(948, 5220),
(948, 5222),
(948, 5238),
(948, 5239),
(948, 5240),
(948, 5241),
(948, 5242),
(948, 5243),
(948, 5244),
(948, 5235),
(949, 5246),
(949, 5220),
(949, 5248),
(949, 5249),
(949, 5250),
(949, 5222),
(949, 5252),
(949, 5253),
(949, 5254),
(949, 5255),
(949, 5256),
(949, 5257),
(949, 5235),
(950, 5259),
(950, 5260),
(950, 5220),
(950, 5222),
(950, 5263),
(950, 5264),
(950, 5265),
(950, 5266),
(950, 5267),
(950, 5268),
(950, 5235),
(951, 5270),
(951, 5271),
(951, 5272),
(951, 5229),
(951, 5274),
(951, 5275),
(951, 5276),
(951, 5277),
(951, 5278),
(952, 5279),
(952, 5220),
(952, 5281),
(952, 5282),
(952, 5283),
(952, 5284),
(952, 5222),
(952, 5235),
(953, 5220),
(953, 5288),
(953, 5289),
(953, 5222),
(953, 5291),
(953, 5292),
(953, 5293),
(953, 5229),
(953, 5295),
(953, 5296),
(953, 5297),
(924, 5220),
(924, 5299),
(924, 5300),
(924, 5222),
(924, 5302),
(924, 5229),
(924, 5304),
(924, 5305),
(924, 5306),
(924, 5307),
(925, 5220),
(925, 5309),
(925, 5222),
(925, 5311),
(925, 5312),
(925, 5313),
(925, 5235),
(926, 5220),
(926, 5802),
(926, 5803),
(926, 5222),
(926, 5805),
(926, 5806),
(926, 5807),
(926, 5808),
(926, 5809),
(926, 5810),
(926, 5229),
(926, 5812),
(927, 5813),
(927, 5814),
(927, 5815),
(927, 5220),
(927, 5817),
(927, 5222),
(927, 5819),
(927, 5820),
(927, 5821),
(927, 5822),
(927, 5823),
(927, 5824),
(927, 5235),
(928, 5826),
(928, 5827),
(928, 5220),
(928, 5829),
(928, 5222),
(928, 5235),
(929, 5220),
(929, 5833),
(929, 5834),
(929, 5222),
(929, 5836),
(929, 5837),
(929, 5235),
(930, 5220),
(930, 5840),
(930, 5841),
(930, 5842),
(930, 5222),
(930, 5844),
(930, 5845),
(930, 5846),
(930, 5847),
(930, 5848),
(930, 5235),
(931, 5850),
(931, 5851),
(931, 5220),
(931, 5853),
(931, 5854),
(931, 5855),
(931, 5856),
(931, 5857),
(931, 5222),
(931, 5859),
(931, 5860),
(931, 5861),
(931, 5235),
(932, 5220),
(932, 5864),
(932, 5222),
(932, 5866),
(932, 5867),
(932, 5868),
(932, 5869),
(932, 5870),
(932, 5871),
(932, 5872),
(932, 5873),
(932, 5874),
(932, 5229),
(932, 5876),
(933, 5220),
(933, 5878),
(933, 5879),
(933, 5222),
(933, 5881),
(933, 5882),
(933, 5235),
(934, 5884),
(934, 5220),
(934, 5222),
(934, 5235),
(935, 5220),
(935, 5889),
(935, 5222),
(935, 5891),
(935, 5892),
(935, 5893),
(935, 5894),
(935, 5235),
(936, 5220),
(936, 5897),
(936, 5898),
(936, 5222),
(936, 5900),
(936, 5901),
(936, 5902),
(936, 5903),
(936, 5235),
(937, 5220),
(937, 5906),
(937, 5907),
(937, 5908),
(937, 5222),
(937, 5910),
(937, 5235),
(938, 5220),
(938, 5913),
(938, 5914),
(938, 5222),
(938, 5916),
(938, 5917),
(938, 5918),
(938, 5919),
(938, 5920),
(938, 5235),
(939, 5922),
(939, 5923),
(939, 5220),
(939, 5925),
(939, 5222),
(939, 5927),
(939, 5928),
(939, 5929),
(939, 5930),
(939, 5931),
(939, 5235),
(940, 5933),
(940, 5934),
(940, 5935),
(940, 5936),
(940, 5937),
(940, 5938),
(940, 5939),
(940, 5940),
(940, 5941),
(940, 5942),
(940, 5943),
(940, 5944),
(940, 5945),
(940, 5946),
(941, 5947),
(941, 5948),
(941, 5949),
(941, 5950),
(941, 5222),
(941, 5235),
(942, 5220),
(942, 5954),
(942, 5955),
(942, 5222),
(942, 5957),
(942, 5958),
(942, 5959),
(942, 5235),
(943, 5961),
(943, 5949),
(943, 5963),
(943, 5964),
(943, 5965),
(970, 5966),
(970, 5220),
(970, 5968),
(970, 5222),
(970, 5970),
(970, 5971),
(970, 5972),
(970, 5973),
(970, 5974),
(970, 5975),
(970, 5235),
(971, 5977),
(971, 5978),
(971, 5979),
(971, 5980),
(971, 5949),
(971, 5982),
(971, 5983),
(971, 5964),
(971, 5965);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
(5966, 'abandoned cart pro for woocommerce'),
(5977, 'add to cart'),
(5813, 'advanced dynamic pricing for woocommerce'),
(5978, 'ajax add to cart'),
(5933, 'ali dropshipping plugin'),
(5934, 'ali2woo'),
(5935, 'alidropship'),
(5936, 'alidropship plugin'),
(5937, 'alidropship plugin free'),
(5938, 'alidropship reviews'),
(5939, 'alidropship woo'),
(5940, 'aliexpress dropshipping for woocommerce'),
(5941, 'aliexpress dropshipping plugin'),
(5942, 'aliexpress plugin'),
(6690, 'atag1'),
(5231, 'autoptimize'),
(5826, 'bulk edit'),
(5827, 'bulk edit post type'),
(5884, 'bulk edit products'),
(5850, 'bundle'),
(5851, 'Bundle products On Woocommerce'),
(5979, 'cart'),
(5259, 'checkout field editor for woocommerce'),
(5980, 'checkout one page'),
(5232, 'clear autoptimize cache automatically'),
(5947, 'coupon'),
(5233, 'cronjob'),
(5922, 'custom email template'),
(5270, 'custom email wordpress'),
(5246, 'custom product options woocommerce'),
(5260, 'customize woocommerce checkout page'),
(5923, 'customize woocommerce emails'),
(5814, 'discount rules for woocommerce'),
(5279, 'dropshipping'),
(5815, 'dynamic pricing woocommerce'),
(5220, 'ecommerce'),
(5829, 'edit custom metadata'),
(5271, 'edit wordpress email templates'),
(5299, 'elementor gallery with links'),
(5300, 'elementor image carousel link'),
(5948, 'email'),
(5961, 'engine'),
(5248, 'epow custom product options for woocommerce'),
(5249, 'extra product options'),
(5250, 'extra product options for woocommerce'),
(5906, 'facebook api'),
(5907, 'facebook chatbot'),
(5908, 'facebook sales channel'),
(5840, 'free gifts for woocommerce'),
(5841, 'gift wrap woocommerce'),
(5842, 'gift wrapper for woocommerce'),
(5853, 'Grouped Product'),
(5854, 'How To Bundle Products On Woocommerce'),
(5925, 'kadence woocommerce email designer'),
(5968, 'mailchimp abandoned cart woocommerce'),
(5878, 'make an offer woocommerce'),
(5833, 'migrate woocommerce to shopify'),
(5879, 'name your price woocommerce'),
(5954, 'order bump woocommerce'),
(5949, 'plugin'),
(5802, 'point of sale for woocommerce'),
(5288, 'points and rewards for woocommerce'),
(5803, 'pos woocommerce'),
(5889, 'pre order plugin woocommerce'),
(5855, 'product'),
(5856, 'product bundle'),
(5309, 'product comparison plugin wordpress'),
(5864, 'product filter for woocommerce'),
(5897, 'product size charts plugin for woocommerce'),
(5950, 'reminder'),
(5963, 'search'),
(5272, 'send custom email in wordpress'),
(5857, 'setting up a grouped product'),
(5982, 'sidebar cart'),
(5898, 'size guide woocommerce'),
(5983, 'sticky add to cart'),
(5289, 'sumo reward points'),
(5281, 'taobao'),
(5282, 'taobao drop shipping'),
(5283, 'taobao dropshipping'),
(5284, 'taobao dropshipping woocommerce'),
(5834, 'transfer woocommerce to shopify'),
(5955, 'upsell order bump offer for woocommerce'),
(5913, 'variation swatches for woocommerce'),
(5964, 'villatheme'),
(5817, 'woo discount rules'),
(5221, 'woo subscription'),
(5914, 'woo variation swatches'),
(5965, 'woocommerce\n	'),
(5222, 'woocommerce'),
(5970, 'woocommerce abandoned cart'),
(5971, 'woocommerce abandoned cart email'),
(5972, 'woocommerce abandoned cart emails'),
(5973, 'woocommerce abandoned cart plugin'),
(5974, 'woocommerce abandoned cart recovery'),
(5866, 'woocommerce ajax filter'),
(5943, 'woocommerce aliexpress'),
(5944, 'woocommerce aliexpress dropshipping extension'),
(5819, 'woocommerce bulk discount'),
(5859, 'woocommerce bundle products'),
(5975, 'woocommerce cart abandonment recovery'),
(5263, 'woocommerce checkout'),
(5264, 'woocommerce checkout custom fields'),
(5265, 'woocommerce checkout field editor'),
(5266, 'woocommerce checkout manager'),
(5267, 'woocommerce checkout page editor'),
(5916, 'woocommerce color swatches'),
(5891, 'woocommerce coming soon product'),
(5311, 'woocommerce compare'),
(5312, 'woocommerce compare products'),
(5313, 'woocommerce compare products plugin'),
(5252, 'WooCommerce Custom Product Options'),
(5820, 'woocommerce discount'),
(5821, 'woocommerce discount plugin'),
(5822, 'woocommerce dynamic pricing &amp; discounts'),
(5927, 'woocommerce email'),
(5928, 'woocommerce email customizer'),
(5929, 'woocommerce email template'),
(5930, 'WooCommerce Email Template Customizer'),
(5268, 'WooCommerce Extra Checkout Fields'),
(5253, 'woocommerce extra product data fields'),
(5254, 'woocommerce extra product options'),
(5910, 'woocommerce facebook chatbot'),
(5867, 'woocommerce filter by category'),
(5868, 'woocommerce filter plugin'),
(5869, 'woocommerce filters'),
(5844, 'woocommerce free gift'),
(5957, 'woocommerce funnel'),
(5238, 'woocommerce gift'),
(5845, 'woocommerce gift box plugin'),
(5239, 'woocommerce gift card'),
(5240, 'woocommerce gift card plugin'),
(5241, 'woocommerce gift cards all in one'),
(5242, 'woocommerce gift certificate'),
(5846, 'woocommerce gift product'),
(5243, 'woocommerce gift vouchers'),
(5847, 'woocommerce gift wrap'),
(5860, 'WooCommerce Grouped Product'),
(5881, 'woocommerce make an offer'),
(5223, 'woocommerce membership plugin'),
(5224, 'woocommerce monthly subscription'),
(5882, 'woocommerce open pricing'),
(5958, 'woocommerce order bump'),
(5805, 'woocommerce point of sale'),
(5291, 'woocommerce points and rewards'),
(5806, 'woocommerce pos'),
(5807, 'woocommerce pos integration'),
(5808, 'woocommerce pos plugin'),
(5809, 'woocommerce pos system'),
(5892, 'woocommerce pre order plugin'),
(5893, 'woocommerce pre orders'),
(5894, 'woocommerce preorders'),
(5870, 'woocommerce price filter'),
(5861, 'woocommerce product bundle'),
(5255, 'woocommerce product custom options'),
(5900, 'woocommerce product dimensions'),
(5256, 'woocommerce product extra options'),
(5871, 'woocommerce product filter plugin'),
(5872, 'woocommerce product filters'),
(5848, 'woocommerce product gift wrap'),
(5302, 'woocommerce product image external url'),
(5257, 'woocommerce product options'),
(5225, 'woocommerce product subscription'),
(5917, 'woocommerce product variations'),
(5823, 'woocommerce quantity based pricing'),
(5824, 'woocommerce quantity discounts'),
(5226, 'woocommerce recurring payments'),
(5292, 'woocommerce reward points'),
(5293, 'woocommerce rewards'),
(5959, 'woocommerce sales funnel'),
(5901, 'woocommerce size chart'),
(5902, 'woocommerce size chart plugin'),
(5903, 'woocommerce size guide'),
(5227, 'woocommerce subscription plugin'),
(5228, 'woocommerce subscriptions'),
(5918, 'woocommerce swatches'),
(5836, 'woocommerce to shopify'),
(5837, 'woocommerce to shopify migration'),
(5244, 'woocommerce ultimate gift card'),
(5919, 'woocommerce variation swatches'),
(5920, 'woocommerce variation swatches and photos'),
(5931, 'woocommerce_email_order_details'),
(5873, 'woof product filter'),
(5874, 'woof woocommerce product filter'),
(5810, 'woopos'),
(5945, 'wooshark'),
(5235, 'wordpress\n	'),
(5229, 'wordpress'),
(5274, 'wordpress customize email template'),
(5946, 'wordpress dropship plugin\n	'),
(5275, 'wordpress email customizer'),
(5276, 'wordpress email template builder'),
(5277, 'wordpress email templates designer'),
(5304, 'wordpress gallery custom links'),
(5305, 'wordpress gallery link'),
(5306, 'wordpress gallery with links'),
(5307, 'wordpress image links\n	'),
(5295, 'wordpress points and rewards'),
(5812, 'wordpress pos\n	'),
(5230, 'wordpress recurring payments\n	'),
(5296, 'wordpress rewards plugin'),
(5278, 'wp email template\n	'),
(5876, 'yith woocommerce ajax product filter\n	'),
(5297, 'yith woocommerce points and rewards\n	');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`gallery_id`),
  ADD KEY `fk_gallery_pro` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `sku` (`sku`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD KEY `fk_cate_product` (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_tag`
--
ALTER TABLE `product_tag`
  ADD KEY `fk_tag_pro` (`product_id`),
  ADD KEY `tag_id` (`tag_id`) USING BTREE;

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1755;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3466;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1185;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15500;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `fk_gallery_pro` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `fk_cate` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cate_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `product_tag`
--
ALTER TABLE `product_tag`
  ADD CONSTRAINT `fk_tag` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`tag_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tag_pro` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
