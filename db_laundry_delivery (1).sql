-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2023 at 01:17 AM
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
-- Database: `db_laundry_delivery`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `total_payment` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `service_id`, `weight`, `address`, `notes`, `total_payment`, `created_on`) VALUES
(1, 6, 2, 18, '123123', 'awdawdawd', 450, '2023-05-24 22:29:37'),
(2, 6, 2, 18, '123123', 'awdawdawd', 450, '2023-05-24 22:29:37'),
(3, 6, 1, 16, 'awdawd', 'awdawdawd', 330, '2023-05-24 22:42:02'),
(4, 6, 1, 16, 'awdawd', 'awdawdawd', 330, '2023-05-24 22:42:04'),
(5, 6, 1, 16, 'awdawd', 'awdawdawd', 330, '2023-05-24 22:42:23'),
(6, 6, 1, 16, 'awdawd', 'awdawdawd', 330, '2023-05-24 22:42:37'),
(7, 6, 1, 16, 'awdawd', 'awdawdawd', 330, '2023-05-24 22:42:47'),
(8, 6, 1, 16, 'awdawd', 'awdawdawd', 330, '2023-05-24 22:42:57'),
(9, 6, 1, 16, 'awdawd', 'awdawdawd', 330, '2023-05-24 22:43:00'),
(10, 6, 1, 16, 'awdawd', 'awdawdawd', 330, '2023-05-24 22:43:06'),
(11, 6, 1, 16, 'awdawd', 'awdawdawd', 330, '2023-05-24 22:44:02'),
(12, 6, 1, 16, 'awdawd', 'awdawdawd', 330, '2023-05-24 22:44:13'),
(13, 6, 1, 16, 'awdawd', 'awdawdawd', 330, '2023-05-24 22:44:21'),
(14, 6, 1, 16, 'awdawd', 'awdawdawd', 330, '2023-05-24 22:44:28'),
(15, 6, 2, 7, 'dsfsdhd ds fgdfsg dfsg sdfg ', 'sdfhs ds gdfg dfg ', 150, '2023-05-24 22:53:32'),
(16, 6, 2, 7, 'dsfsdhd ds fgdfsg dfsg sdfg ', 'sdfhs ds gdfg dfg ', 150, '2023-05-24 22:53:34'),
(17, 6, 2, 7, 'dsfsdhd ds fgdfsg dfsg sdfg ', 'sdfhs ds gdfg dfg ', 150, '2023-05-24 22:58:37'),
(18, 6, 2, 7, 'dsfsdhd ds fgdfsg dfsg sdfg ', 'sdfhs ds gdfg dfg ', 150, '2023-05-24 22:58:57'),
(19, 6, 2, 7, 'dsfsdhd ds fgdfsg dfsg sdfg ', 'sdfhs ds gdfg dfg ', 150, '2023-05-24 22:59:05'),
(20, 6, 2, 7, 'dsfsdhd ds fgdfsg dfsg sdfg ', 'sdfhs ds gdfg dfg ', 150, '2023-05-24 22:59:48'),
(21, 6, 2, 7, 'dsfsdhd ds fgdfsg dfsg sdfg ', 'sdfhs ds gdfg dfg ', 150, '2023-05-24 23:02:08');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `delivery_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `rider_id` int(11) NOT NULL,
  `status` enum('pending','processing','completed','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`delivery_id`, `booking_id`, `rider_id`, `status`) VALUES
(1, 15, 0, 'pending'),
(2, 16, 0, 'pending'),
(3, 17, 0, 'pending'),
(4, 18, 0, 'pending'),
(5, 19, 0, 'pending'),
(6, 20, 0, 'pending'),
(7, 21, 0, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `permission_level` enum('superadmin','admin','employee','customer','rider') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `permission_level`) VALUES
(1, 'superadmin'),
(2, 'admin'),
(3, 'employee'),
(4, 'customer'),
(5, 'rider');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `name`, `price`) VALUES
(1, 'Wash', 70),
(2, 'Wash & Fold', 110),
(3, 'Wash, Fold & Iron', 150);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `username`, `password`) VALUES
(5, 1, 'superadmin', '$2y$10$gJk0pGBYc8/tEfVFJEDBtOkdcSHHOfSU3nAZgmtraIRelywfF49Yy'),
(6, 4, 'test', '$2y$10$.ORIthlktLy9IgZDWb4bMOp/tSMpLeW/KjmP35/LoZEMLB7oBPELa'),
(7, 2, 'admin', '$2y$10$zfZ7AsuA78u1DOEIb0muAORo/m3FF/dEhFRQO7iKTkKlkJi9nN0Di');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `user_info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_info_id`, `user_id`, `fname`, `lname`, `email`, `phone`) VALUES
(5, 5, 'admin', 'admin', 'seanzki143@gmail.com', 1231233211),
(6, 6, 'test', 'test', 'test@test2.com', 1231233215),
(7, 7, 'admin', 'admin', 'admin@admin.com', 1231231237);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`delivery_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_info_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
