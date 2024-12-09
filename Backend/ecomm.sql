-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2024 at 12:05 PM
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
-- Database: `ecomm`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `Cat_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `Cat_name`) VALUES
(1, 'all'),
(2, 'clothes'),
(3, 'tech');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  `symbol` varchar(1) DEFAULT NULL,
  `price_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `label`, `symbol`, `price_id`) VALUES
(1, 'USD', '$', 1),
(2, 'USD', '$', 2),
(3, 'USD', '$', 3),
(4, 'USD', '$', 4),
(5, 'USD', '$', 5),
(6, 'USD', '$', 6),
(7, 'USD', '$', 7),
(8, 'USD', '$', 8);

-- --------------------------------------------------------

--
-- Table structure for table `hotfix`
--

CREATE TABLE `hotfix` (
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `display_value` varchar(255) DEFAULT NULL,
  `valuex` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotfix`
--

INSERT INTO `hotfix` (`name`, `type`, `display_value`, `valuex`, `product_id`) VALUES
('Size', 'text', '40', '40', 'huarache-x-stussy-le'),
('Size', 'text', '41', '41', 'huarache-x-stussy-le'),
('Size', 'text', '42', '42', 'huarache-x-stussy-le'),
('Size', 'text', '43', '43', 'huarache-x-stussy-le'),
('Size', 'text', 'Small', 'S', 'jacket-canada-goosee'),
('Size', 'text', 'Medium', 'M', 'jacket-canada-goosee'),
('Size', 'text', 'Large', 'L', 'jacket-canada-goosee'),
('Size', 'text', 'Extra Large', 'XL', 'jacket-canada-goosee'),
('Color', 'swatch', 'Green', '#44FF03', 'ps-5'),
('Color', 'swatch', 'Cyan', '#03FFF7', 'ps-5'),
('Color', 'swatch', 'Blue', '#030BFF', 'ps-5'),
('Color', 'swatch', 'Black', '#000000', 'ps-5'),
('Color', 'swatch', 'White', '#FFFFFF', 'ps-5'),
('Capacity', 'text', '512G', '512G', 'ps-5'),
('Capacity', 'text', '1T', '1T', 'ps-5'),
('Color', 'swatch', 'Green', '#44FF03', 'xbox-series-s'),
('Color', 'swatch', 'Cyan', '#03FFF7', 'xbox-series-s'),
('Color', 'swatch', 'Blue', '#030BFF', 'xbox-series-s'),
('Color', 'swatch', 'Black', '#000000', 'xbox-series-s'),
('Color', 'swatch', 'White', '#FFFFFF', 'xbox-series-s'),
('Capacity', 'text', '512G', '512G', 'xbox-series-s'),
('Capacity', 'text', '1T', '1T', 'xbox-series-s'),
('Capacity', 'text', '256GB', '256GB', 'apple-imac-2021'),
('Capacity', 'text', '512GB', '512GB', 'apple-imac-2021'),
('With USB 3 ports', 'text', 'Yes', 'Yes', 'apple-imac-2021'),
('With USB 3 ports', 'text', 'No', 'No', 'apple-imac-2021'),
('Touch ID in keyboard', 'text', 'Yes', 'Yes', 'apple-imac-2021'),
('Touch ID in keyboard', 'text', 'No', 'No', 'apple-imac-2021'),
('Capacity', 'text', '512G', '512G', 'apple-iphone-12-pro'),
('Capacity', 'text', '1T', '1T', 'apple-iphone-12-pro'),
('Color', 'swatch', 'Green', '#44FF03', 'apple-iphone-12-pro'),
('Color', 'swatch', 'Cyan', '#03FFF7', 'apple-iphone-12-pro'),
('Color', 'swatch', 'Blue', '#030BFF', 'apple-iphone-12-pro'),
('Color', 'swatch', 'Black', '#000000', 'apple-iphone-12-pro'),
('Color', 'swatch', 'White', '#FFFFFF', 'apple-iphone-12-pro');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`attributes`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `price`, `attributes`, `created_at`) VALUES
(12, 'jacket-canada-goosee', 518.47, '{\"Size\":\"S\"}', '2024-11-27 09:30:55'),
(13, 'apple-airtag', 120.57, '[]', '2024-11-27 09:32:04'),
(14, 'apple-imac-2021', 1688.03, '{\"Capacity\":\"512GB\",\"With USB 3 ports\":\"No\",\"Touch ID in keyboard\":\"Yes\"}', '2024-11-27 09:32:04'),
(15, 'apple-imac-2021', 1688.03, '{\"Capacity\":\"512GB\",\"With USB 3 ports\":\"No\",\"Touch ID in keyboard\":\"Yes\"}', '2024-11-27 11:16:40'),
(16, 'apple-airtag', 120.57, '[]', '2024-11-27 11:30:41'),
(17, 'apple-airtag', 120.57, '[]', '2024-11-27 19:34:35'),
(18, 'jacket-canada-goosee', 518.47, '{\"Size\":\"XL\"}', '2024-11-27 19:34:35'),
(19, 'huarache-x-stussy-le', 144.69, '{\"Size\":\"42\"}', '2024-11-27 19:34:35'),
(20, 'huarache-x-stussy-le', 144.69, '{\"Size\":\"40\"}', '2024-11-28 08:46:14'),
(21, 'huarache-x-stussy-le', 144.69, '{\"Size\":\"43\"}', '2024-11-28 08:48:50'),
(22, 'huarache-x-stussy-le', 144.69, '{\"Size\":\"43\"}', '2024-11-28 08:49:23'),
(23, 'jacket-canada-goosee', 518.47, '{\"Size\":\"M\"}', '2024-11-28 08:53:56'),
(24, 'jacket-canada-goosee', 518.47, '{\"Size\":\"XL\"}', '2024-11-28 08:58:39'),
(25, 'apple-imac-2021', 1688.03, '{\"Capacity\":\"512GB\",\"With USB 3 ports\":\"No\",\"Touch ID in keyboard\":\"Yes\"}', '2024-11-28 09:31:47'),
(26, 'apple-imac-2021', 1688.03, '{\"Capacity\":\"512GB\",\"With USB 3 ports\":\"Yes\",\"Touch ID in keyboard\":\"Yes\"}', '2024-11-28 09:31:47'),
(27, 'apple-imac-2021', 1688.03, '{\"Capacity\":\"256GB\",\"Touch ID in keyboard\":\"No\",\"With USB 3 ports\":\"Yes\"}', '2024-11-29 17:37:54'),
(28, 'jacket-canada-goosee', 518.47, '{\"Size\":\"XL\"}', '2024-12-01 18:52:14'),
(29, 'ps-5', 844.02, '{\"Color\":\"#44FF03\",\"Capacity\":\"1T\"}', '2024-12-02 21:34:33'),
(30, 'apple-iphone-12-pro', 1000.76, '{\"Color\":\"#03FFF7\",\"Capacity\":\"1T\"}', '2024-12-03 17:09:06'),
(31, 'apple-iphone-12-pro', 1000.76, '{\"Color\":\"#03FFF7\",\"Capacity\":\"1T\"}', '2024-12-03 17:09:06'),
(32, 'apple-iphone-12-pro', 1000.76, '{\"Capacity\":\"512G\",\"Color\":\"#44FF03\"}', '2024-12-03 17:09:06'),
(33, 'apple-iphone-12-pro', 1000.76, '{\"Capacity\":\"512G\",\"Color\":\"#44FF03\"}', '2024-12-03 17:09:06'),
(34, 'apple-airtag', 120.57, '[]', '2024-12-03 17:18:52'),
(35, 'apple-iphone-12-pro', 1000.76, '{\"Capacity\":\"512G\",\"Color\":\"#44FF03\"}', '2024-12-03 17:18:52'),
(36, 'ps-5', 844.02, '{\"Color\":\"#03FFF7\",\"Capacity\":\"1T\"}', '2024-12-03 17:18:52'),
(37, 'apple-imac-2021', 1688.03, '{\"Capacity\":\"256GB\",\"With USB 3 ports\":\"Yes\",\"Touch ID in keyboard\":\"Yes\"}', '2024-12-03 17:18:52'),
(38, 'apple-airtag', 120.57, '[]', '2024-12-03 17:28:46'),
(39, 'apple-imac-2021', 1688.03, '{\"Capacity\":\"256GB\",\"With USB 3 ports\":\"No\",\"Touch ID in keyboard\":\"Yes\"}', '2024-12-03 17:28:46'),
(40, 'apple-iphone-12-pro', 1000.76, '{\"Capacity\":[{\"display_value\":\"512G\",\"valuex\":\"512G\",\"selected\":true},{\"display_value\":\"1T\",\"valuex\":\"1T\",\"selected\":false}],\"Color\":[{\"display_value\":\"Green\",\"valuex\":\"#44FF03\",\"selected\":true},{\"display_value\":\"Cyan\",\"valuex\":\"#03FFF7\",\"selected\":false},{\"display_value\":\"Blue\",\"valuex\":\"#030BFF\",\"selected\":false},{\"display_value\":\"Black\",\"valuex\":\"#000000\",\"selected\":false},{\"display_value\":\"White\",\"valuex\":\"#FFFFFF\",\"selected\":false}]}', '2024-12-05 21:49:16'),
(41, 'apple-iphone-12-pro', 1000.76, '{\"Capacity\":[{\"valuex\":\"512G\",\"display_value\":\"512G\",\"selected\":false},{\"valuex\":\"1T\",\"display_value\":\"1T\",\"selected\":true}],\"Color\":[{\"valuex\":\"#44FF03\",\"display_value\":\"Green\",\"selected\":false},{\"valuex\":\"#03FFF7\",\"display_value\":\"Cyan\",\"selected\":true},{\"valuex\":\"#030BFF\",\"display_value\":\"Blue\",\"selected\":false},{\"valuex\":\"#000000\",\"display_value\":\"Black\",\"selected\":false},{\"valuex\":\"#FFFFFF\",\"display_value\":\"White\",\"selected\":false}]}', '2024-12-05 21:50:47'),
(42, 'apple-iphone-12-pro', 1000.76, '{\"Capacity\":[{\"display_value\":\"512G\",\"valuex\":\"512G\",\"selected\":true},{\"display_value\":\"1T\",\"valuex\":\"1T\",\"selected\":false}],\"Color\":[{\"display_value\":\"Green\",\"valuex\":\"#44FF03\",\"selected\":true},{\"display_value\":\"Cyan\",\"valuex\":\"#03FFF7\",\"selected\":false},{\"display_value\":\"Blue\",\"valuex\":\"#030BFF\",\"selected\":false},{\"display_value\":\"Black\",\"valuex\":\"#000000\",\"selected\":false},{\"display_value\":\"White\",\"valuex\":\"#FFFFFF\",\"selected\":false}]}', '2024-12-05 21:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`id`, `product_id`, `amount`) VALUES
(1, 'huarache-x-stussy-le', 144.69),
(2, 'jacket-canada-goosee', 518.47),
(3, 'ps-5', 844.02),
(4, 'xbox-series-s', 333.99),
(5, 'apple-imac-2021', 1688.03),
(6, 'apple-iphone-12-pro', 1000.76),
(7, 'apple-airpods-pro', 300.23),
(8, 'apple-airtag', 120.57);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `inStock` tinyint(1) NOT NULL,
  `Des` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `inStock`, `Des`, `category_id`, `brand`) VALUES
('apple-airpods-pro', 'AirPods Pro', 0, '\n<h3>Magic like you’ve never heard</h3>\n<p>AirPods Pro have been designed to deliver Active Noise Cancellation for immersive sound, Transparency mode so you can hear your surroundings, and a customizable fit for all-day comfort. Just like AirPods, AirPods', 3, 'Apple'),
('apple-airtag', 'AirTag', 1, '\n<h1>Lose your knack for losing things.</h1>\n<p>AirTag is an easy way to keep track of your stuff. Attach one to your keys, slip another one in your backpack. And just like that, they’re on your radar in the Find My app. AirTag has your back.</p>\n', 3, 'Apple'),
('apple-imac-2021', 'iMac 2021', 1, 'The new iMac!', 3, 'Apple'),
('apple-iphone-12-pro', 'iPhone 12 Pro', 1, 'This is iPhone 12. Nothing else to say.', 3, 'Apple'),
('huarache-x-stussy-le', 'Nike Air Huarache Le', 1, '<p>Great sneakers for everyday use!</p>', 2, 'Nike x Stussy'),
('jacket-canada-goosee', 'Jacket', 1, '<p>Awesome winter jacket</p>', 2, 'Canada Goose'),
('ps-5', 'PlayStation 5', 1, '<p>A good gaming console. Plays games of PS4! Enjoy if you can buy it mwahahahaha</p>', 3, 'Sony'),
('xbox-series-s', 'Xbox Series S 512GB', 0, '\n<div>\n    <ul>\n        <li><span>Hardware-beschleunigtes Raytracing macht dein Spiel noch realistischer</span></li>\n        <li><span>Spiele Games mit bis zu 120 Bilder pro Sekunde</span></li>\n        <li><span>Minimiere Ladezeiten mit einer speziell ent', 3, 'Microsoft');

-- --------------------------------------------------------

--
-- Table structure for table `product_gallery`
--

CREATE TABLE `product_gallery` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `img_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_gallery`
--

INSERT INTO `product_gallery` (`id`, `product_id`, `img_url`) VALUES
(25, 'huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_2_720x.jpg?v=1612816087'),
(26, 'huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_1_720x.jpg?v=1612816087'),
(27, 'huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_3_720x.jpg?v=1612816087'),
(28, 'huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_5_720x.jpg?v=1612816087'),
(29, 'huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_4_720x.jpg?v=1612816087'),
(30, 'jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016105/product-image/2409L_61.jpg'),
(31, 'jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016107/product-image/2409L_61_a.jpg'),
(32, 'jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016108/product-image/2409L_61_b.jpg'),
(33, 'jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016109/product-image/2409L_61_c.jpg'),
(34, 'jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016110/product-image/2409L_61_d.jpg'),
(35, 'jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058169/product-image/2409L_61_o.png'),
(36, 'jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058159/product-image/2409L_61_p.png'),
(37, 'ps-5', 'https://images-na.ssl-images-amazon.com/images/I/510VSJ9mWDL._SL1262_.jpg'),
(38, 'ps-5', 'https://images-na.ssl-images-amazon.com/images/I/610%2B69ZsKCL._SL1500_.jpg'),
(39, 'ps-5', 'https://images-na.ssl-images-amazon.com/images/I/51iPoFwQT3L._SL1230_.jpg'),
(40, 'ps-5', 'https://images-na.ssl-images-amazon.com/images/I/61qbqFcvoNL._SL1500_.jpg'),
(41, 'ps-5', 'https://images-na.ssl-images-amazon.com/images/I/51HCjA3rqYL._SL1230_.jpg'),
(42, 'xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg'),
(43, 'xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg'),
(44, 'xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg'),
(45, 'xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg'),
(46, 'xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg'),
(47, 'apple-imac-2021', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/imac-24-blue-selection-hero-202104?wid=904&hei=840&fmt=jpeg&qlt=80&.v=1617492405000'),
(48, 'apple-iphone-12-pro', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-12-pro-family-hero?wid=940&amp;hei=1112&amp;fmt=jpeg&amp;qlt=80&amp;.v=1604021663000'),
(49, 'apple-airpods-pro', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000'),
(50, 'apple-airtag', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/airtag-double-select-202104?wid=445&hei=370&fmt=jpeg&qlt=95&.v=1617761672000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `price_id` (`price_id`);

--
-- Indexes for table `hotfix`
--
ALTER TABLE `hotfix`
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_gallery`
--
ALTER TABLE `product_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_gallery`
--
ALTER TABLE `product_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `currency`
--
ALTER TABLE `currency`
  ADD CONSTRAINT `currency_ibfk_1` FOREIGN KEY (`price_id`) REFERENCES `prices` (`id`);

--
-- Constraints for table `hotfix`
--
ALTER TABLE `hotfix`
  ADD CONSTRAINT `hotfix_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `prices`
--
ALTER TABLE `prices`
  ADD CONSTRAINT `prices_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_gallery`
--
ALTER TABLE `product_gallery`
  ADD CONSTRAINT `product_gallery_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
