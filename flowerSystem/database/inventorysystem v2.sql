-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 03, 2024 at 07:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventorysystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `fullname`, `username`, `role_id`, `password`) VALUES
(1, 'Andrei Co', 'main', 1, 'main'),
(32, 'Hazel Canciller', 'hazel', 2, '1234567890'),
(36, 'Andrei', 'user', 2, 'khaleed8232');

--
-- Triggers `admins`
--
DELIMITER $$
CREATE TRIGGER `Admin_Insert_Trigger` AFTER INSERT ON `admins` FOR EACH ROW BEGIN
    INSERT INTO AuditLogs (table_name, operation_type, record_id, username)
    VALUES ('admins', 'INSERT', NEW.admin_id, 'admin');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Admin_Update_Trigger` AFTER UPDATE ON `admins` FOR EACH ROW BEGIN
    INSERT INTO AuditLogs (table_name, operation_type, record_id, username)
    VALUES ('admins', 'UPDATE', NEW.admin_id, 'admin');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `auditlogs`
--

CREATE TABLE `auditlogs` (
  `log_id` int(11) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `operation_type` varchar(10) NOT NULL,
  `record_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auditlogs`
--

INSERT INTO `auditlogs` (`log_id`, `table_name`, `operation_type`, `record_id`, `username`, `timestamp`) VALUES
(182, 'Products', 'UPDATE', 37, 'root@localhost', '2023-12-19 08:54:41'),
(183, 'admins', 'INSERT', 23, 'root@localhost', '2023-12-19 09:09:13'),
(184, 'Category', 'UPDATE', 7, 'root@localhost', '2023-12-19 09:10:52'),
(185, 'admins', 'INSERT', 24, 'root@localhost', '2023-12-19 09:34:02'),
(186, 'Products', 'INSERT', 139, 'root@localhost', '2023-12-19 09:45:25'),
(187, 'Products', 'INSERT', 140, 'admin@localhost', '2023-12-19 09:47:02'),
(188, 'Staff', 'INSERT', 2047, 'root@localhost', '2023-12-19 10:34:26'),
(189, 'Staff', 'INSERT', 2048, 'root@localhost', '2023-12-19 10:34:47'),
(190, 'admins', 'INSERT', 25, 'root@localhost', '2023-12-19 14:09:58'),
(191, 'admins', 'UPDATE', 25, 'admin@localhost', '2023-12-19 14:11:33'),
(192, 'admins', 'UPDATE', 25, 'admin@localhost', '2023-12-19 14:11:56'),
(193, 'admins', 'UPDATE', 25, 'admin@localhost', '2023-12-19 14:13:16'),
(194, 'admins', 'UPDATE', 25, 'admin@localhost', '2023-12-19 14:14:26'),
(195, 'admins', 'UPDATE', 25, 'admin@localhost', '2023-12-19 14:14:52'),
(196, 'admins', 'INSERT', 26, 'root@localhost', '2023-12-19 14:20:48'),
(197, 'admins', 'INSERT', 27, 'root@localhost', '2023-12-19 14:22:25'),
(198, 'Products', 'UPDATE', 133, 'root@localhost', '2023-12-19 14:47:02'),
(199, 'Products', 'UPDATE', 133, 'root@localhost', '2023-12-19 14:50:59'),
(200, 'Products', 'INSERT', 141, 'root@localhost', '2023-12-19 14:54:54'),
(201, 'Products', 'INSERT', 142, 'root@localhost', '2023-12-19 14:55:11'),
(202, 'Products', 'INSERT', 143, 'root@localhost', '2023-12-19 14:55:29'),
(203, 'Category', 'INSERT', 16, 'root@localhost', '2023-12-20 16:50:39'),
(204, 'Staff', 'INSERT', 2049, 'root@localhost', '2023-12-23 15:02:49'),
(205, 'Staff', 'INSERT', 2050, 'root@localhost', '2023-12-23 15:06:27'),
(206, 'Staff', 'INSERT', 2051, 'root@localhost', '2023-12-23 15:32:10'),
(207, 'Staff', 'INSERT', 2052, 'root@localhost', '2023-12-23 16:56:50'),
(208, 'Staff', 'INSERT', 2053, 'root@localhost', '2023-12-23 16:58:06'),
(209, 'Staff', 'INSERT', 2054, 'root@localhost', '2023-12-23 16:58:06'),
(210, 'Staff', 'INSERT', 2055, 'root@localhost', '2023-12-23 16:59:37'),
(211, 'Staff', 'INSERT', 2056, 'root@localhost', '2023-12-23 16:59:52'),
(212, 'Staff', 'INSERT', 2057, 'root@localhost', '2023-12-23 17:03:47'),
(213, 'Staff', 'INSERT', 2058, 'root@localhost', '2023-12-23 17:04:19'),
(214, 'Staff', 'INSERT', 2059, 'root@localhost', '2023-12-23 17:46:12'),
(215, 'Staff', 'INSERT', 2060, 'root@localhost', '2023-12-23 17:46:15'),
(216, 'Staff', 'INSERT', 2061, 'root@localhost', '2023-12-23 17:59:22'),
(217, 'Staff', 'INSERT', 2062, 'root@localhost', '2023-12-23 17:59:27'),
(218, 'Staff', 'INSERT', 2063, 'root@localhost', '2023-12-24 11:41:36'),
(219, 'Staff', 'INSERT', 2064, 'root@localhost', '2023-12-24 12:07:03'),
(220, 'Staff', 'INSERT', 2065, 'root@localhost', '2023-12-24 12:08:37'),
(221, 'Staff', 'INSERT', 2066, 'root@localhost', '2023-12-24 12:10:36'),
(222, 'Staff', 'INSERT', 2067, 'root@localhost', '2023-12-25 07:38:41'),
(223, 'Staff', 'INSERT', 2068, 'root@localhost', '2023-12-25 07:48:10'),
(224, 'Staff', 'INSERT', 2069, 'root@localhost', '2023-12-25 07:51:11'),
(225, 'admins', 'UPDATE', 24, 'root@localhost', '2023-12-28 11:02:58'),
(226, 'admins', 'UPDATE', 24, 'root@localhost', '2023-12-28 11:05:58'),
(227, 'admins', 'UPDATE', 1, 'admin@localhost', '2023-12-28 15:51:03'),
(228, 'admins', 'UPDATE', 24, 'admin@localhost', '2023-12-28 15:51:13'),
(229, 'admins', 'INSERT', 28, 'root@localhost', '2023-12-28 16:16:05'),
(230, 'admins', 'INSERT', 29, 'root@localhost', '2023-12-28 16:18:18'),
(231, 'admins', 'INSERT', 32, 'root@localhost', '2023-12-28 16:27:37'),
(232, 'admins', 'INSERT', 33, 'admin', '2023-12-29 14:44:11'),
(233, 'admins', 'INSERT', 34, 'username', '2023-12-29 15:52:24'),
(234, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 10:07:23'),
(235, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 10:07:33'),
(236, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 10:07:53'),
(237, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 10:08:10'),
(238, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 10:11:02'),
(239, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 10:11:12'),
(240, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 10:13:02'),
(241, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 10:13:35'),
(242, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 10:13:40'),
(243, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 10:20:20'),
(244, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 10:20:27'),
(245, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 10:24:59'),
(246, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 11:27:27'),
(247, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 11:27:38'),
(248, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 11:29:24'),
(249, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 11:33:01'),
(250, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 11:39:26'),
(251, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 11:43:43'),
(252, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 11:45:26'),
(253, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 11:49:10'),
(254, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 11:53:53'),
(255, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 11:54:28'),
(256, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 11:55:21'),
(257, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 11:55:42'),
(258, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 11:56:39'),
(259, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 11:57:20'),
(260, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 14:23:56'),
(261, 'admins', 'INSERT', 35, 'admin', '2024-01-01 18:30:30'),
(262, 'admins', 'UPDATE', 35, 'admin', '2024-01-01 18:30:56'),
(263, 'Staff', 'UPDATE', 2044, 'admin', '2024-01-01 18:33:50'),
(264, 'Staff', 'INSERT', 2070, 'admin', '2024-01-02 09:36:16'),
(265, 'Staff', 'INSERT', 2071, 'admin', '2024-01-02 09:38:58'),
(266, 'Staff', 'INSERT', 2072, 'admin', '2024-01-02 09:42:00'),
(267, 'Staff', 'INSERT', 2073, 'admin', '2024-01-02 09:53:05'),
(268, 'Category', 'UPDATE', 6, 'admin', '2024-01-02 09:53:37'),
(269, 'Category', 'UPDATE', 6, 'admin', '2024-01-02 09:53:41'),
(270, 'Products', 'UPDATE', 143, 'admin', '2024-01-02 09:53:53'),
(271, 'admins', 'INSERT', 36, 'admin', '2024-01-02 09:54:58'),
(272, 'Products', 'INSERT', 144, 'admin', '2024-01-02 09:55:51'),
(273, 'Products', 'UPDATE', 144, 'admin', '2024-01-02 09:56:02'),
(274, 'Products', 'UPDATE', 141, 'admin', '2024-01-02 09:57:34');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(6, 'Crochet Items'),
(7, 'Flower Bouquets'),
(9, 'Flower Bouquet & Crochet Items');

--
-- Triggers `category`
--
DELIMITER $$
CREATE TRIGGER `Category_Insert_Trigger` AFTER INSERT ON `category` FOR EACH ROW BEGIN
    INSERT INTO AuditLogs (table_name, operation_type, record_id, username)
    VALUES ('Category', 'INSERT', NEW.category_id, 'admin');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Category_Update_Trigger` AFTER UPDATE ON `category` FOR EACH ROW BEGIN
    INSERT INTO AuditLogs (table_name, operation_type, record_id, username)
    VALUES ('Category', 'UPDATE', NEW.category_id, 'admin');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `quantity`, `category_id`, `price`, `created_at`, `updated_at`) VALUES
(34, 'Lily of The Valley', '15', 9, 159.00, '2024-01-01 14:44:30', '2024-01-01 14:44:30'),
(141, 'Sunflower', '20', 9, 199.00, '2024-01-01 14:44:30', '2024-01-02 09:57:34'),
(143, 'Lily of The Valley', '20', 9, 599.00, '2024-01-01 14:44:30', '2024-01-02 09:53:53');

--
-- Triggers `products`
--
DELIMITER $$
CREATE TRIGGER `Products_Insert_Trigger` AFTER INSERT ON `products` FOR EACH ROW BEGIN
    INSERT INTO AuditLogs (table_name, operation_type, record_id, username)
    VALUES ('Products', 'INSERT', NEW.product_id, 'admin');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Products_Update_Trigger` AFTER UPDATE ON `products` FOR EACH ROW BEGIN
    INSERT INTO AuditLogs (table_name, operation_type, record_id, username)
    VALUES ('Products', 'UPDATE', NEW.product_id, 'admin');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'main admin'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `contact_no` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `firstname`, `lastname`, `contact_no`, `password`, `username`, `created_at`, `updated_at`) VALUES
(2044, 'Ronnell Andrei', 'Co', '09518524866', 'khaleed8232', 'andrexia', '2024-01-01 14:56:44', '2024-01-01 18:33:50'),
(2047, 'Hazel', 'Canciller', '09513457721', 'hazel123456789', 'hazel', '2024-01-01 14:56:44', '2024-01-01 14:56:44'),
(2073, 'Andrei', 'Co', '09518524866', 'khaleed8232', 'staff123', '2024-01-02 09:53:05', '2024-01-02 09:53:05');

--
-- Triggers `staff`
--
DELIMITER $$
CREATE TRIGGER `Staff_Insert_Trigger` AFTER INSERT ON `staff` FOR EACH ROW BEGIN
    INSERT INTO AuditLogs (table_name, operation_type, record_id, username)
    VALUES ('Staff', 'INSERT', NEW.staff_id, 'admin');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Staff_Update_Trigger` AFTER UPDATE ON `staff` FOR EACH ROW BEGIN
    INSERT INTO AuditLogs (table_name, operation_type, record_id, username)
    VALUES ('Staff', 'UPDATE', NEW.staff_id, 'admin');
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `auditlogs`
--
ALTER TABLE `auditlogs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `FK_category_id` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `auditlogs`
--
ALTER TABLE `auditlogs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2074;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
