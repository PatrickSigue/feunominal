-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 03:31 PM
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
-- Database: `tix`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `c_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `e_id` int(11) NOT NULL,
  `e_name` varchar(100) NOT NULL,
  `c_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `v_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_dates`
--

CREATE TABLE `event_dates` (
  `e_d_id` int(11) NOT NULL,
  `e_id` int(11) NOT NULL,
  `e_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_times`
--

CREATE TABLE `event_times` (
  `e_t_id` int(11) NOT NULL,
  `e_d_id` int(11) NOT NULL,
  `e_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `o_date` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `t_id` int(11) NOT NULL,
  `e_t_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `seat_num` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `purchase_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `s_name` varchar(50) NOT NULL,
  `user_type` enum('customer','organizer','admin','') NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `password`, `email`, `f_name`, `s_name`, `user_type`, `created_at`) VALUES
(1, 'admin', 'admin@admin.com', 'admin', 'admin', 'admin', '2025-04-09 12:56:27'),
(3, 'test', 'test@test.com', 'test', 'testing', 'customer', '2025-04-09 20:01:17'),
(4, 'jose', 'jose@jose.com', 'jose', 'jose', 'customer', '2025-04-09 20:55:14');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `v_id` int(11) NOT NULL,
  `v_name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `def_seat_plan` varchar(255) NOT NULL,
  `up_seat_plan` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `map_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`e_id`),
  ADD KEY `c_id` (`c_id`),
  ADD KEY `v_id` (`v_id`),
  ADD KEY `org_id` (`org_id`);

--
-- Indexes for table `event_dates`
--
ALTER TABLE `event_dates`
  ADD PRIMARY KEY (`e_d_id`),
  ADD KEY `e_id` (`e_id`);

--
-- Indexes for table `event_times`
--
ALTER TABLE `event_times`
  ADD PRIMARY KEY (`e_t_id`),
  ADD KEY `e_d_id` (`e_d_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`t_id`),
  ADD KEY `e_t_id` (`e_t_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`v_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `e_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_dates`
--
ALTER TABLE `event_dates`
  MODIFY `e_d_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_times`
--
ALTER TABLE `event_times`
  MODIFY `e_t_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `category` (`c_id`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`v_id`) REFERENCES `venues` (`v_id`),
  ADD CONSTRAINT `events_ibfk_3` FOREIGN KEY (`org_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `event_dates`
--
ALTER TABLE `event_dates`
  ADD CONSTRAINT `event_dates_ibfk_1` FOREIGN KEY (`e_id`) REFERENCES `events` (`e_id`);

--
-- Constraints for table `event_times`
--
ALTER TABLE `event_times`
  ADD CONSTRAINT `event_times_ibfk_1` FOREIGN KEY (`e_d_id`) REFERENCES `event_dates` (`e_d_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`e_t_id`) REFERENCES `event_times` (`e_t_id`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
