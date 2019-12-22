-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2019 at 11:23 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-commerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `image`, `title`, `link`, `status`, `created_at`, `updated_at`) VALUES
(1, '44159.png', 'Banner Image', 'products/t-shirts', 1, '2019-12-11 13:03:22', '2019-12-11 13:03:22'),
(3, '62146.png', 'Banner Image3', 'products/t-shirts', 1, '2019-12-11 13:04:10', '2019-12-11 13:04:10'),
(4, '96157.png', 'Shoe Banner', 'products/shoes', 1, '2019-12-12 01:30:14', '2019-12-12 01:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `session_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `product_name`, `product_code`, `product_color`, `size`, `price`, `quantity`, `user_email`, `session_id`, `created_at`, `updated_at`) VALUES
(1, 17, 'Green Casual T-Shirt', 'GTS001-L', 'Green', 'Large', '2600', 1, 'lekhad19@gmail.com', 'WYPYiXGHgXDsGuPpWsyyfB6g9ToMaSgY1uVWPfzc', NULL, NULL),
(2, 17, 'Green Casual T-Shirt', 'GTS001-M', 'Green', 'Medium', '2400', 1, 'lekhad19@gmail.com', 'WYPYiXGHgXDsGuPpWsyyfB6g9ToMaSgY1uVWPfzc', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `description`, `url`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(7, 0, 'T-Shirts', 'T-Shirts Category', 't-shirts', 1, NULL, '2019-11-28 15:48:58', '2019-11-28 15:48:58'),
(8, 0, 'Shoes', 'Shoes Category', 'shoes', 0, NULL, '2019-11-28 15:49:52', '2019-12-06 02:03:01'),
(9, 7, 'Casual T-Shirts', 'Casual T-Shirts', 'casual-t-shirts', 1, NULL, '2019-11-28 16:16:47', '2019-11-28 16:16:47'),
(12, 7, 'Formal T-Shirts', 'Formal T-Shirts is good', 'formal-tshirts', 1, NULL, '2019-12-03 04:52:05', '2019-12-03 04:52:05'),
(13, 8, 'Casual Shoes', 'This is under causal shoe', 'casual-shoe', 1, NULL, '2019-12-03 05:19:15', '2019-12-03 05:19:15'),
(14, 8, 'test shoes', 'test', 'test-shoes', 1, NULL, '2019-12-04 23:50:13', '2019-12-04 23:50:13'),
(15, 8, 'test2 shoe', 'testing the shoe', 'test2-shoe', 0, NULL, '2019-12-04 23:57:57', '2019-12-04 23:57:57'),
(16, 8, 'test3 shoe 3', 'testing shoe 3', 'test3-shoe', 0, NULL, '2019-12-04 23:58:52', '2019-12-05 00:16:47');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_name`) VALUES
(1, 'AF', 'Afghanistan'),
(2, 'AL', 'Albania'),
(3, 'DZ', 'Algeria'),
(4, 'DS', 'American Samoa'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antarctica'),
(9, 'AG', 'Antigua and Barbuda'),
(10, 'AR', 'Argentina'),
(11, 'AM', 'Armenia'),
(12, 'AW', 'Aruba'),
(13, 'AU', 'Australia'),
(14, 'AT', 'Austria'),
(15, 'AZ', 'Azerbaijan'),
(16, 'BS', 'Bahamas'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BY', 'Belarus'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BJ', 'Benin'),
(24, 'BM', 'Bermuda'),
(25, 'BT', 'Bhutan'),
(26, 'BO', 'Bolivia'),
(27, 'BA', 'Bosnia and Herzegovina'),
(28, 'BW', 'Botswana'),
(29, 'BV', 'Bouvet Island'),
(30, 'BR', 'Brazil'),
(31, 'IO', 'British Indian Ocean Territory'),
(32, 'BN', 'Brunei Darussalam'),
(33, 'BG', 'Bulgaria'),
(34, 'BF', 'Burkina Faso'),
(35, 'BI', 'Burundi'),
(36, 'KH', 'Cambodia'),
(37, 'CM', 'Cameroon'),
(38, 'CA', 'Canada'),
(39, 'CV', 'Cape Verde'),
(40, 'KY', 'Cayman Islands'),
(41, 'CF', 'Central African Republic'),
(42, 'TD', 'Chad'),
(43, 'CL', 'Chile'),
(44, 'CN', 'China'),
(45, 'CX', 'Christmas Island'),
(46, 'CC', 'Cocos (Keeling) Islands'),
(47, 'CO', 'Colombia'),
(48, 'KM', 'Comoros'),
(49, 'CD', 'Democratic Republic of the Congo'),
(50, 'CG', 'Republic of Congo'),
(51, 'CK', 'Cook Islands'),
(52, 'CR', 'Costa Rica'),
(53, 'HR', 'Croatia (Hrvatska)'),
(54, 'CU', 'Cuba'),
(55, 'CY', 'Cyprus'),
(56, 'CZ', 'Czech Republic'),
(57, 'DK', 'Denmark'),
(58, 'DJ', 'Djibouti'),
(59, 'DM', 'Dominica'),
(60, 'DO', 'Dominican Republic'),
(61, 'TP', 'East Timor'),
(62, 'EC', 'Ecuador'),
(63, 'EG', 'Egypt'),
(64, 'SV', 'El Salvador'),
(65, 'GQ', 'Equatorial Guinea'),
(66, 'ER', 'Eritrea'),
(67, 'EE', 'Estonia'),
(68, 'ET', 'Ethiopia'),
(69, 'FK', 'Falkland Islands (Malvinas)'),
(70, 'FO', 'Faroe Islands'),
(71, 'FJ', 'Fiji'),
(72, 'FI', 'Finland'),
(73, 'FR', 'France'),
(74, 'FX', 'France, Metropolitan'),
(75, 'GF', 'French Guiana'),
(76, 'PF', 'French Polynesia'),
(77, 'TF', 'French Southern Territories'),
(78, 'GA', 'Gabon'),
(79, 'GM', 'Gambia'),
(80, 'GE', 'Georgia'),
(81, 'DE', 'Germany'),
(82, 'GH', 'Ghana'),
(83, 'GI', 'Gibraltar'),
(84, 'GK', 'Guernsey'),
(85, 'GR', 'Greece'),
(86, 'GL', 'Greenland'),
(87, 'GD', 'Grenada'),
(88, 'GP', 'Guadeloupe'),
(89, 'GU', 'Guam'),
(90, 'GT', 'Guatemala'),
(91, 'GN', 'Guinea'),
(92, 'GW', 'Guinea-Bissau'),
(93, 'GY', 'Guyana'),
(94, 'HT', 'Haiti'),
(95, 'HM', 'Heard and Mc Donald Islands'),
(96, 'HN', 'Honduras'),
(97, 'HK', 'Hong Kong'),
(98, 'HU', 'Hungary'),
(99, 'IS', 'Iceland'),
(100, 'IN', 'India'),
(101, 'IM', 'Isle of Man'),
(102, 'ID', 'Indonesia'),
(103, 'IR', 'Iran (Islamic Republic of)'),
(104, 'IQ', 'Iraq'),
(105, 'IE', 'Ireland'),
(106, 'IL', 'Israel'),
(107, 'IT', 'Italy'),
(108, 'CI', 'Ivory Coast'),
(109, 'JE', 'Jersey'),
(110, 'JM', 'Jamaica'),
(111, 'JP', 'Japan'),
(112, 'JO', 'Jordan'),
(113, 'KZ', 'Kazakhstan'),
(114, 'KE', 'Kenya'),
(115, 'KI', 'Kiribati'),
(116, 'KP', 'Korea, Democratic People\'s Republic of'),
(117, 'KR', 'Korea, Republic of'),
(118, 'XK', 'Kosovo'),
(119, 'KW', 'Kuwait'),
(120, 'KG', 'Kyrgyzstan'),
(121, 'LA', 'Lao People\'s Democratic Republic'),
(122, 'LV', 'Latvia'),
(123, 'LB', 'Lebanon'),
(124, 'LS', 'Lesotho'),
(125, 'LR', 'Liberia'),
(126, 'LY', 'Libyan Arab Jamahiriya'),
(127, 'LI', 'Liechtenstein'),
(128, 'LT', 'Lithuania'),
(129, 'LU', 'Luxembourg'),
(130, 'MO', 'Macau'),
(131, 'MK', 'North Macedonia'),
(132, 'MG', 'Madagascar'),
(133, 'MW', 'Malawi'),
(134, 'MY', 'Malaysia'),
(135, 'MV', 'Maldives'),
(136, 'ML', 'Mali'),
(137, 'MT', 'Malta'),
(138, 'MH', 'Marshall Islands'),
(139, 'MQ', 'Martinique'),
(140, 'MR', 'Mauritania'),
(141, 'MU', 'Mauritius'),
(142, 'TY', 'Mayotte'),
(143, 'MX', 'Mexico'),
(144, 'FM', 'Micronesia, Federated States of'),
(145, 'MD', 'Moldova, Republic of'),
(146, 'MC', 'Monaco'),
(147, 'MN', 'Mongolia'),
(148, 'ME', 'Montenegro'),
(149, 'MS', 'Montserrat'),
(150, 'MA', 'Morocco'),
(151, 'MZ', 'Mozambique'),
(152, 'MM', 'Myanmar'),
(153, 'NA', 'Namibia'),
(154, 'NR', 'Nauru'),
(155, 'NP', 'Nepal'),
(156, 'NL', 'Netherlands'),
(157, 'AN', 'Netherlands Antilles'),
(158, 'NC', 'New Caledonia'),
(159, 'NZ', 'New Zealand'),
(160, 'NI', 'Nicaragua'),
(161, 'NE', 'Niger'),
(162, 'NG', 'Nigeria'),
(163, 'NU', 'Niue'),
(164, 'NF', 'Norfolk Island'),
(165, 'MP', 'Northern Mariana Islands'),
(166, 'NO', 'Norway'),
(167, 'OM', 'Oman'),
(168, 'PK', 'Pakistan'),
(169, 'PW', 'Palau'),
(170, 'PS', 'Palestine'),
(171, 'PA', 'Panama'),
(172, 'PG', 'Papua New Guinea'),
(173, 'PY', 'Paraguay'),
(174, 'PE', 'Peru'),
(175, 'PH', 'Philippines'),
(176, 'PN', 'Pitcairn'),
(177, 'PL', 'Poland'),
(178, 'PT', 'Portugal'),
(179, 'PR', 'Puerto Rico'),
(180, 'QA', 'Qatar'),
(181, 'RE', 'Reunion'),
(182, 'RO', 'Romania'),
(183, 'RU', 'Russian Federation'),
(184, 'RW', 'Rwanda'),
(185, 'KN', 'Saint Kitts and Nevis'),
(186, 'LC', 'Saint Lucia'),
(187, 'VC', 'Saint Vincent and the Grenadines'),
(188, 'WS', 'Samoa'),
(189, 'SM', 'San Marino'),
(190, 'ST', 'Sao Tome and Principe'),
(191, 'SA', 'Saudi Arabia'),
(192, 'SN', 'Senegal'),
(193, 'RS', 'Serbia'),
(194, 'SC', 'Seychelles'),
(195, 'SL', 'Sierra Leone'),
(196, 'SG', 'Singapore'),
(197, 'SK', 'Slovakia'),
(198, 'SI', 'Slovenia'),
(199, 'SB', 'Solomon Islands'),
(200, 'SO', 'Somalia'),
(201, 'ZA', 'South Africa'),
(202, 'GS', 'South Georgia South Sandwich Islands'),
(203, 'SS', 'South Sudan'),
(204, 'ES', 'Spain'),
(205, 'LK', 'Sri Lanka'),
(206, 'SH', 'St. Helena'),
(207, 'PM', 'St. Pierre and Miquelon'),
(208, 'SD', 'Sudan'),
(209, 'SR', 'Suriname'),
(210, 'SJ', 'Svalbard and Jan Mayen Islands'),
(211, 'SZ', 'Swaziland'),
(212, 'SE', 'Sweden'),
(213, 'CH', 'Switzerland'),
(214, 'SY', 'Syrian Arab Republic'),
(215, 'TW', 'Taiwan'),
(216, 'TJ', 'Tajikistan'),
(217, 'TZ', 'Tanzania, United Republic of'),
(218, 'TH', 'Thailand'),
(219, 'TG', 'Togo'),
(220, 'TK', 'Tokelau'),
(221, 'TO', 'Tonga'),
(222, 'TT', 'Trinidad and Tobago'),
(223, 'TN', 'Tunisia'),
(224, 'TR', 'Turkey'),
(225, 'TM', 'Turkmenistan'),
(226, 'TC', 'Turks and Caicos Islands'),
(227, 'TV', 'Tuvalu'),
(228, 'UG', 'Uganda'),
(229, 'UA', 'Ukraine'),
(230, 'AE', 'United Arab Emirates'),
(231, 'GB', 'United Kingdom'),
(232, 'US', 'United States'),
(233, 'UM', 'United States minor outlying islands'),
(234, 'UY', 'Uruguay'),
(235, 'UZ', 'Uzbekistan'),
(236, 'VU', 'Vanuatu'),
(237, 'VA', 'Vatican City State'),
(238, 'VE', 'Venezuela'),
(239, 'VN', 'Vietnam'),
(240, 'VG', 'Virgin Islands (British)'),
(241, 'VI', 'Virgin Islands (U.S.)'),
(242, 'WF', 'Wallis and Futuna Islands'),
(243, 'EH', 'Western Sahara'),
(244, 'YE', 'Yemen'),
(245, 'ZM', 'Zambia'),
(246, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(10) UNSIGNED NOT NULL,
  `coupon_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `amount_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expiry_date` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_code`, `amount`, `amount_type`, `expiry_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'wudkkkededitted', 100, 'Percentage', '2019-12-25', 1, '2019-12-10 01:29:31', '2019-12-11 00:34:16'),
(6, 'testing1', 80, 'Fixed', '2019-12-18', 1, '2019-12-10 14:16:40', '2019-12-16 13:37:40');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_addresses`
--

CREATE TABLE `delivery_addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_addresses`
--

INSERT INTO `delivery_addresses` (`id`, `user_id`, `user_email`, `name`, `address`, `city`, `state`, `country`, `pincode`, `mobile`, `created_at`, `updated_at`) VALUES
(1, 2, 'samiat@gmail.com', 'Samiat Adeleke', 'Ologuneru', 'Ibadan', 'Oyo State', 'Nigeria', '200130', '08168516930', '2019-12-15 17:24:34', '2019-12-16 01:24:34'),
(3, 1, 'lekhad19@gmail.com', 'Adeleke Hammed', 'Mokola', 'Ibadan', 'Oyo State', 'Angola', '200130', '08029009959', '2019-12-16 08:40:39', '2019-12-16 16:40:39');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_11_26_230809_create_category_table', 2),
(4, '2019_11_28_102732_create_products_table', 3),
(5, '2019_11_30_225400_create_products_attributes_table', 4),
(7, '2019_12_07_095502_create_cart_table', 5),
(8, '2019_12_09_144513_create_coupons_table', 6),
(10, '2019_12_11_031803_create_banners_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `shipping_charges` float NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `coupon_amount` float NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `grand_total` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `user_email`, `name`, `address`, `city`, `state`, `pincode`, `country`, `mobile`, `shipping_charges`, `coupon_code`, `coupon_amount`, `order_status`, `payment_method`, `grand_total`, `created_at`, `updated_at`) VALUES
(1, 1, 'lekhad19@gmail.com', 'Adeleke Hammed', 'Mokola', 'Ibadan', 'Oyo State', '200130', 'Angola', '08029009959', 0, 'testing1', 80, 'New', 'Paypal', 4920, '2019-12-16 06:16:36', '2019-12-16 14:16:36'),
(2, 1, 'lekhad19@gmail.com', 'Adeleke Hammed', 'Mokola', 'Ibadan', 'Oyo State', '200130', 'Angola', '08029009959', 0, 'testing1', 80, 'New', 'COD', 4920, '2019-12-16 07:47:57', '2019-12-16 15:47:57'),
(3, 1, 'lekhad19@gmail.com', 'Adeleke Hammed', 'Mokola', 'Ibadan', 'Oyo State', '200130', 'Angola', '08029009959', 0, 'testing1', 80, 'New', 'COD', 4920, '2019-12-16 07:50:37', '2019-12-16 15:50:37'),
(4, 1, 'lekhad19@gmail.com', 'Adeleke Hammed', 'Mokola', 'Ibadan', 'Oyo State', '200130', 'Angola', '08029009959', 0, 'testing1', 80, 'New', 'COD', 4920, '2019-12-16 07:51:00', '2019-12-16 15:51:00'),
(5, 1, 'lekhad19@gmail.com', 'Adeleke Hammed', 'Mokola', 'Ibadan', 'Oyo State', '200130', 'Angola', '08029009959', 0, 'testing1', 80, 'New', 'COD', 4920, '2019-12-16 07:51:28', '2019-12-16 15:51:28'),
(6, 1, 'lekhad19@gmail.com', 'Adeleke Hammed', 'Mokola', 'Ibadan', 'Oyo State', '200130', 'Angola', '08029009959', 0, 'testing1', 80, 'New', 'Paypal', 4920, '2019-12-16 07:53:19', '2019-12-16 15:53:19'),
(7, 1, 'lekhad19@gmail.com', 'Adeleke Hammed', 'Mokola', 'Ibadan', 'Oyo State', '200130', 'Angola', '08029009959', 0, 'testing1', 80, 'New', 'Paypal', 4920, '2019-12-16 08:40:47', '2019-12-16 16:40:47');

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_size` varchar(255) NOT NULL,
  `product_color` varchar(255) NOT NULL,
  `product_price` float NOT NULL,
  `product_qty` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders_products`
--

INSERT INTO `orders_products` (`id`, `order_id`, `user_id`, `product_id`, `product_code`, `product_name`, `product_size`, `product_color`, `product_price`, `product_qty`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 17, 'GTS001-L', 'Green Casual T-Shirt', '', 'Green', 0, 0, '2019-12-16 07:51:28', '2019-12-16 15:51:28'),
(2, 5, 1, 17, 'GTS001-M', 'Green Casual T-Shirt', '', 'Green', 0, 0, '2019-12-16 07:51:28', '2019-12-16 15:51:28'),
(3, 6, 1, 17, 'GTS001-L', 'Green Casual T-Shirt', 'Large', 'Green', 2600, 1, '2019-12-16 07:53:19', '2019-12-16 15:53:19'),
(4, 6, 1, 17, 'GTS001-M', 'Green Casual T-Shirt', 'Medium', 'Green', 2400, 1, '2019-12-16 07:53:19', '2019-12-16 15:53:19'),
(5, 7, 1, 17, 'GTS001-L', 'Green Casual T-Shirt', 'Large', 'Green', 2600, 1, '2019-12-16 08:40:48', '2019-12-16 16:40:48'),
(6, 7, 1, 17, 'GTS001-M', 'Green Casual T-Shirt', 'Medium', 'Green', 2400, 1, '2019-12-16 08:40:48', '2019-12-16 16:40:48');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `care` text COLLATE utf8_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_name`, `product_code`, `product_color`, `description`, `care`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES
(9, 7, 'Blue Sport Shirts', 'BSS000', 'Blue', 'This is blue sport shirt', '', 1009.00, '28861.png', 1, '2019-11-29 09:52:00', '2019-12-05 03:46:10'),
(10, 9, 'Red Casual T-Shirts', 'BSS001s', 'Red', 'This is Red shirts', '', 5000.00, '41515.png', 1, '2019-11-30 05:24:31', '2019-12-07 13:45:26'),
(17, 9, 'Green Casual T-Shirt', 'GSS100', 'Green', 'This is a green shirt', '', 8000.00, '20535.png', 1, '2019-12-03 04:39:54', '2019-12-07 13:44:39'),
(21, 13, 'Blue Sport Shoe', 'BSS201', 'Blue', 'This is blue sport shoe', '', 2000.00, '48718.png', 1, '2019-12-05 03:22:40', '2019-12-05 03:48:15'),
(22, 9, 'Blue Casual T-Shirt', 'BT001', 'Blue', 'Blue T-Shirt has a round neck, half sleeves', 'This product is build 100% of cotton', 1200.00, '95855.png', 1, '2019-12-06 00:16:00', '2019-12-07 13:44:08'),
(23, 9, 'Blue Casual Sport Shirts', 'BCSPS101', 'Blue', 'This is blue casual sport shirts', 'Made with blue sport shirt', 30000.00, '73464.png', 0, '2019-12-07 15:02:37', '2019-12-07 15:57:01'),
(24, 9, 'Red Casual T-Shirts', 'RCTS101', 'Red', 'This is red casual t-shirt', 'Made with red fabric', 60000.00, '12072.png', 1, '2019-12-07 15:04:07', '2019-12-07 15:04:07'),
(25, 9, 'Green Casual T-Shirt', 'GSS100', 'Green', '', '', 70000.00, '92722.png', 0, '2019-12-07 15:47:24', '2019-12-07 15:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `products_attributes`
--

CREATE TABLE `products_attributes` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `sku` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products_attributes`
--

INSERT INTO `products_attributes` (`id`, `product_id`, `sku`, `size`, `price`, `stock`, `created_at`, `updated_at`) VALUES
(1, 9, 'BT01-L', 'Large', 1500.00, 15, '2019-12-01 13:14:27', '2019-12-01 13:14:27'),
(2, 9, 'BT01-M', 'Medium', 1200.00, 12, '2019-12-01 13:14:27', '2019-12-01 13:14:27'),
(3, 9, 'BT01-S', 'Small', 1000.00, 10, '2019-12-01 13:14:27', '2019-12-01 13:14:27'),
(4, 9, 'BT01-L', 'Large', 1500.00, 15, '2019-12-01 13:20:12', '2019-12-01 13:20:12'),
(5, 9, 'BT01-M', 'Medium', 1200.00, 12, '2019-12-01 13:20:12', '2019-12-01 13:20:12'),
(6, 9, 'BT01-S', 'Small', 1000.00, 10, '2019-12-01 13:20:12', '2019-12-01 13:20:12'),
(8, 9, 'BT01-XL', 'XLarge', 3000.00, 20, '2019-12-01 14:03:29', '2019-12-01 14:03:29'),
(9, 9, 'BT00-MS', 'Medium', 2500.00, 15, '2019-12-01 14:03:30', '2019-12-01 14:03:30'),
(10, 9, 'BT01-SS', 'Small', 2000.00, 10, '2019-12-01 14:03:30', '2019-12-01 14:03:30'),
(11, 9, 'BT01-S', 'Large', 1500.00, 10, '2019-12-01 16:12:29', '2019-12-01 16:12:29'),
(12, 9, 'jnfk', '89', 899.00, 99, '2019-12-02 01:18:50', '2019-12-02 01:18:50'),
(13, 10, 'sbdh', '18', 82.00, 2, '2019-12-02 01:24:22', '2019-12-08 15:48:35'),
(14, 10, 'BT01-S', 'Large', 1500.00, 2, '2019-12-02 01:37:48', '2019-12-08 15:48:35'),
(15, 10, 'BS01-L', 'Large', 1500.00, 2, '2019-12-02 01:40:15', '2019-12-08 15:48:35'),
(18, 9, 'Adjdk', '288', 828.00, 8, '2019-12-03 03:39:11', '2019-12-03 03:39:11'),
(19, 18, 'CodeBSS001-38', '38', 2000.00, 10, '2019-12-03 09:33:23', '2019-12-03 09:33:23'),
(20, 18, 'CodeBSS001-40', '40', 2200.00, 10, '2019-12-03 09:33:23', '2019-12-03 09:33:23'),
(23, 21, 'BSS-L', '200', 20000.00, 10, '2019-12-05 03:23:52', '2019-12-07 03:44:07'),
(24, 21, 'BSS-M', '150', 15000.00, 0, '2019-12-05 03:23:52', '2019-12-07 03:44:07'),
(25, 21, 'BSS-S', '100', 10000.00, 0, '2019-12-05 03:23:52', '2019-12-07 03:44:07'),
(26, 17, 'GTS001-L', 'Large', 2600.00, 3, '2019-12-05 07:08:16', '2019-12-11 00:48:38'),
(27, 17, 'GTS001-M', 'Medium', 2400.00, 3, '2019-12-05 07:08:16', '2019-12-11 00:48:38'),
(28, 17, 'GTS001-S', 'Small', 2000.00, 3, '2019-12-05 07:08:16', '2019-12-11 00:48:38'),
(29, 22, 'DBS-001', 'Large', 1900.00, 19, '2019-12-06 02:23:18', '2019-12-06 02:23:18'),
(33, 22, 'DBS-002', 'Medium', 1200.00, 15, '2019-12-06 02:49:57', '2019-12-06 02:49:57');

-- --------------------------------------------------------

--
-- Table structure for table `products_images`
--

CREATE TABLE `products_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products_images`
--

INSERT INTO `products_images` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(13, 17, '38847.png', '2019-12-06 01:11:43', '2019-12-06 09:11:43'),
(14, 17, '8461.png', '2019-12-06 01:11:45', '2019-12-06 09:11:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pincode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `address`, `city`, `state`, `country`, `pincode`, `mobile`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `admin`) VALUES
(1, 'Adeleke Hammed', 'Mokola', 'Ibadan', 'Oyo State', 'Angola', '200130', '08029009959', 'lekhad19@gmail.com', '$2y$10$vvhywPtClrg/H15Ad33Kfu2.SFj27GoefQWWVWrwZGUCMyGnZy4Vu', 'Qenc3UITFD1cKB6JUJa5b9gXb6fKZxVAdZYMrGQ9YNMg0cPUZjqEUTiC95Ne', '2019-11-25 23:46:20', '2019-12-16 16:40:38', 1),
(2, 'Samiat Adelekes', 'Akatapa Area, Unity Bus Stop', 'Ibadan', 'Oyo State', 'Nigeria', '200130', '08029009959', 'samiat@gmail.com', '$2y$10$rgqR90s1C/UsZUO3y74bce2tVmBVnbxJKjikeBVEoYWmVxp.gaQ3C', '6uERYkUn4wPxT4Ddy2gxFmpLmy4Oq08lJ7PIWzH20JTwBFrZdfN54lg6mQus', '2019-12-13 04:00:07', '2019-12-16 01:24:34', NULL),
(3, 'Jimsheg', '', '', '', '', '', '', 'jimsheg@gmail.com', '$2y$10$7bV8Vm7VxGJZVHdBPXoWyOqIpu8YOdng4G/BbmnCcA5bmIPdUDSdO', 'q2DquT9W4DK1ESPjLwPQ4zZNAubn6HqWQ4wkFVhdf1l94FFkfKRh37OETqVm', '2019-12-13 04:02:23', '2019-12-13 04:02:23', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_attributes`
--
ALTER TABLE `products_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_images`
--
ALTER TABLE `products_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_email_index` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `products_attributes`
--
ALTER TABLE `products_attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `products_images`
--
ALTER TABLE `products_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
