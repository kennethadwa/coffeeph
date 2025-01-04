-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2025 at 10:15 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffeeph`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Pastries', '2024-12-15 13:58:00', '2024-12-15 13:58:00'),
(2, 'Coffee Beverages', '2024-12-15 13:58:10', '2024-12-19 23:45:32');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `payment_id` int(11) NOT NULL,
  `method_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`payment_id`, `method_name`, `created_at`, `updated_at`) VALUES
(1, 'Cash', '2024-12-15 18:35:11', '2024-12-15 18:35:11');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`) VALUES
(4, 1, 'Egg Pie', 'A creamy custard pie with a caramelized top and flaky crust.', 120.00, 50, '../uploads/products/eggpie.jpg', '2024-12-16 11:35:28', '2024-12-20 03:23:00'),
(5, 1, 'Creme Brulee', 'A classic French dessert made with a rich, creamy custard base topped with a crispy caramelized sugar layer.', 120.00, 50, '../uploads/products/brulee.jpg', '2024-12-16 11:50:23', '2024-12-20 04:19:23'),
(6, 1, 'Ube Cheese Pandesal', 'A colorful twist on the classic pandesal with ube and cheese filling.', 80.00, 50, '../uploads/products/ube-cheese.jpg', '2024-12-16 11:51:17', '2024-12-20 03:36:33'),
(7, 1, 'Pistachio Croissant', 'A buttery, flaky croissant filled with rich pistachio cream and topped with crushed pistachios.', 180.00, 50, '../uploads/products/pistachio.jpg', '2024-12-16 11:51:58', '2024-12-20 04:10:28'),
(8, 1, 'Dulce Banana Bread', ' A delightful pastry made with ripe bananas wrapped in a buttery, soft dough and drizzled with a rich caramel sauce. ', 180.00, 50, '../uploads/products/dulce_banana.jpg', '2024-12-16 11:52:25', '2024-12-20 04:09:52'),
(9, 1, 'Nutella Escargot', 'A delightful pastry, the Nutella Escargot is a spiral-shaped croissant dough filled with creamy Nutella chocolate spread.', 150.00, 50, '../uploads/products/nutella.jpg', '2024-12-16 11:52:54', '2024-12-20 05:28:35'),
(10, 1, 'Cheese Danish', 'Bread with a bright red sweet filling, often made from leftover pastries.', 155.00, 50, '../uploads/products/67654eccced5c.jpg', '2024-12-16 11:53:28', '2024-12-20 11:02:36'),
(11, 1, 'Blueberry Scone', 'A delicious, tender baked good made with a combination of flour, butter, sugar, and milk or cream.', 150.00, 15, '../uploads/products/67654dfe46d3a.jpg', '2024-12-16 12:01:07', '2024-12-20 12:40:59'),
(12, 1, 'Cinnamon Roll', 'A sweet, spiral-shaped pastry made from soft, fluffy dough rolled with a rich cinnamon-sugar filling. It\'s typically baked until golden and topped with a luscious glaze or cream cheese frosting.', 120.00, 55, '../uploads/products/67654c6e0309d.jpg', '2024-12-16 12:01:34', '2024-12-20 10:52:30'),
(13, 2, 'Caffe Americano', 'Espresso shots diluted with hot water for a rich and bold flavor.', 150.00, 100, '../uploads/products/676551f51f39e.jpeg', '2024-12-16 12:05:24', '2024-12-20 11:16:22'),
(14, 2, 'Cappuccino', ' Espresso topped with steamed milk and a thick layer of milk foam.', 180.00, 50, '../uploads/products/67655304ed742.jpg', '2024-12-16 12:06:29', '2024-12-20 11:21:36'),
(15, 2, 'Caramel Macchiato', 'Vanilla syrup, steamed milk, and espresso, topped with caramel drizzle.', 190.00, 120, '../uploads/products/676559d437e4f.jpg', '2024-12-16 12:08:25', '2024-12-20 11:49:40'),
(16, 2, 'Nitro Cold Brew', 'Cold brew coffee infused with nitrogen for a creamy texture and smooth flavor.', 180.00, 55, '../uploads/products/6765628d5dbf4.jpg', '2024-12-16 12:09:53', '2024-12-20 12:26:53'),
(17, 2, 'Pumpkin Spice Latte', 'Espresso, steamed milk, and pumpkin spice flavoring, topped with whipped cream and pumpkin spice.', 250.00, 60, '../uploads/products/676562ce243be.jpg', '2024-12-16 12:11:17', '2024-12-20 12:27:58'),
(18, 2, 'Latte', 'Espresso combined with steamed milk and a thin layer of foam.', 175.00, 127, '../uploads/products/6765633a3d730.jpg', '2024-12-16 12:13:39', '2024-12-20 12:29:46'),
(19, 2, 'Cold Brew', 'a coffee concentrate made by steeping coffee grounds in water at a cool temperature for a long time.', 150.00, 100, '../uploads/products/676618f204628.jpg', '2024-12-21 01:25:06', '2024-12-21 01:25:06'),
(20, 2, 'Iced Coffee Chocolate', 'A chocolate drink that has a mixed of caffeine', 170.00, 20, '../uploads/products/67661bb7f407e.jpg', '2024-12-21 01:36:56', '2024-12-21 01:36:56');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `status` varchar(255) DEFAULT 'Pending',
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `total_amount`, `payment_id`, `status`, `transaction_date`) VALUES
(13, 3, 1170.00, 1, 'Completed', '2024-12-21 02:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items`
--

CREATE TABLE `transaction_items` (
  `transaction_item_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_items`
--

INSERT INTO `transaction_items` (`transaction_item_id`, `transaction_id`, `product_id`, `quantity`, `price`) VALUES
(15, 13, 19, 2, 150.00),
(16, 13, 13, 5, 150.00),
(17, 13, 5, 1, 120.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account_type` int(11) NOT NULL DEFAULT 2,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `contact`, `address`, `email`, `password`, `account_type`, `created_at`, `updated_at`) VALUES
(3, 'Kenneth', 'Lorenzo', '09123456789', '123 Main Street, City', 'kennetics1@gmail.com', '$2y$10$cybraq8uP7M1qulLpbzKXuyI67TxN0Oxdb4LYqyvu/udtRt4JzQD2', 2, '2024-12-15 11:31:36', '2024-12-21 09:21:43'),
(4, 'Blakie', 'Bun', '09123456789', 'Balintawak, Lipa City', 'blakiebun11@gmail.com', '$2y$10$OprHxo/y0E./UszNPnzuSOFh3tbZtvY1uoViq8L5FdWnVd9vDlpDG', 1, '2024-12-15 11:41:13', '2024-12-15 11:41:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD PRIMARY KEY (`transaction_item_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaction_items`
--
ALTER TABLE `transaction_items`
  MODIFY `transaction_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payment_method` (`payment_id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD CONSTRAINT `transaction_items_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
