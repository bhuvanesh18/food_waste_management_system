-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Apr 10, 2021 at 04:35 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fwms`
--

-- --------------------------------------------------------

--
-- Table structure for table `cook_item_waste`
--

CREATE TABLE `cook_item_waste` (
  `food_waste_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cook_item_waste`
--

INSERT INTO `cook_item_waste` (`food_waste_id`, `recipe_id`) VALUES
(4, 6),
(5, 7),
(6, 2),
(11, 6),
(14, 11),
(16, 18);

-- --------------------------------------------------------

--
-- Table structure for table `days_info`
--

CREATE TABLE `days_info` (
  `day_id` varchar(3) NOT NULL,
  `day_value` varchar(10) NOT NULL,
  `day_order` tinyint(1) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `days_info`
--

INSERT INTO `days_info` (`day_id`, `day_value`, `day_order`, `is_available`) VALUES
('fri', 'friday', 5, 1),
('mon', 'monday', 1, 1),
('sat', 'saturday', 6, 1),
('sun', 'sunday', 7, 1),
('thu', 'thursday', 4, 1),
('tue', 'tuesday', 2, 1),
('wed', 'wednesday', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `days_session_info`
--

CREATE TABLE `days_session_info` (
  `id` int(11) NOT NULL,
  `day_id` varchar(3) NOT NULL,
  `session_name` varchar(10) NOT NULL,
  `is_available` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `days_session_info`
--

INSERT INTO `days_session_info` (`id`, `day_id`, `session_name`, `is_available`) VALUES
(1, 'fri', 'breakfast', 1),
(2, 'fri', 'lunch', 1),
(3, 'fri', 'snacks', 1),
(4, 'fri', 'dinner', 1),
(5, 'mon', 'breakfast', 1),
(6, 'mon', 'lunch', 1),
(7, 'mon', 'snacks', 1),
(8, 'mon', 'dinner', 1),
(9, 'sat', 'breakfast', 1),
(10, 'sat', 'lunch', 1),
(11, 'sat', 'snacks', 1),
(12, 'sat', 'dinner', 1),
(13, 'sun', 'breakfast', 1),
(14, 'sun', 'lunch', 1),
(15, 'sun', 'snacks', 1),
(16, 'sun', 'dinner', 0),
(17, 'thu', 'breakfast', 1),
(18, 'thu', 'lunch', 1),
(19, 'thu', 'snacks', 1),
(20, 'thu', 'dinner', 1),
(21, 'tue', 'breakfast', 1),
(22, 'tue', 'lunch', 1),
(23, 'tue', 'snacks', 1),
(24, 'tue', 'dinner', 1),
(25, 'wed', 'breakfast', 1),
(26, 'wed', 'lunch', 1),
(27, 'wed', 'snacks', 1),
(28, 'wed', 'dinner', 1);

-- --------------------------------------------------------

--
-- Table structure for table `food_wastes`
--

CREATE TABLE `food_wastes` (
  `id` int(11) NOT NULL,
  `venue` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `day_id` varchar(3) NOT NULL,
  `session` varchar(10) NOT NULL,
  `waste_category` varchar(20) NOT NULL,
  `weight` float(10,2) NOT NULL,
  `entry_by` varchar(50) NOT NULL,
  `entry_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food_wastes`
--

INSERT INTO `food_wastes` (`id`, `venue`, `date`, `day_id`, `session`, `waste_category`, `weight`, `entry_by`, `entry_at`) VALUES
(1, 'BOYS_DINING', '2021-02-04', 'thu', 'breakfast', 'FOOD_WASTE', 12.50, 'super@admin.in', '2021-02-04 21:10:06'),
(2, 'BOYS_DINING', '2021-02-04', 'thu', 'lunch', 'FOOD_WASTE', 6.50, 'super@admin.in', '2021-02-04 21:11:01'),
(3, 'BOYS_DINING', '2021-02-04', 'thu', 'breakfast', 'COOK_WASTE', 2.00, 'super@admin.in', '2021-02-04 21:13:33'),
(4, 'BOYS_DINING', '2021-02-01', 'mon', 'dinner', 'COOK_ITEM_WASTE', 4.00, 'super@admin.in', '2021-02-04 21:15:14'),
(5, 'BOYS_DINING', '2021-02-01', 'mon', 'dinner', 'COOK_ITEM_WASTE', 1.00, 'super@admin.in', '2021-02-04 21:16:08'),
(6, 'GIRLS_DINING', '2021-02-01', 'mon', 'breakfast', 'COOK_ITEM_WASTE', 10.00, 'super@admin.in', '2021-02-04 21:17:44'),
(7, 'BOYS_DINING', '2021-02-01', 'mon', 'breakfast', 'FOOD_WASTE', 6.50, 'bhuvi@gmail.com', '2021-02-05 17:58:21'),
(8, 'BOYS_DINING', '2021-01-25', 'mon', 'breakfast', 'FOOD_WASTE', 3.55, 'super@admin.in', '2021-02-05 21:16:07'),
(9, 'BOYS_DINING', '2021-02-08', 'mon', 'breakfast', 'FOOD_WASTE', 5.00, 'bhuvi@gmail.com', '2021-02-09 10:12:37'),
(10, 'BOYS_DINING', '2021-02-08', 'mon', 'breakfast', 'COOK_WASTE', 12.30, 'bhuvi@gmail.com', '2021-02-09 10:12:54'),
(11, 'BOYS_DINING', '2021-02-08', 'mon', 'dinner', 'COOK_ITEM_WASTE', 7.00, 'bhuvi@gmail.com', '2021-02-09 10:20:08'),
(12, 'BOYS_DINING', '2021-03-29', 'mon', 'breakfast', 'FOOD_WASTE', 20.00, 'super@admin.in', '2021-03-29 09:58:27'),
(13, 'BOYS_DINING', '2021-03-29', 'mon', 'breakfast', 'COOK_WASTE', 12.50, 'super@admin.in', '2021-03-29 10:00:07'),
(14, 'BOYS_DINING', '2021-03-29', 'mon', 'breakfast', 'COOK_ITEM_WASTE', 10.00, 'super@admin.in', '2021-03-29 10:02:23'),
(15, 'BOYS_DINING', '2021-03-30', 'tue', 'lunch', 'FOOD_WASTE', 10.25, 'super@admin.in', '2021-03-30 12:34:29'),
(16, 'BOYS_DINING', '2021-03-30', 'tue', 'lunch', 'COOK_ITEM_WASTE', 5.00, 'super@admin.in', '2021-03-30 12:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `day` varchar(3) NOT NULL,
  `session` varchar(10) NOT NULL,
  `recipe_name` varchar(50) NOT NULL,
  `recipe_image_path` varchar(200) NOT NULL,
  `venue` varchar(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `day`, `session`, `recipe_name`, `recipe_image_path`, `venue`, `is_active`) VALUES
(1, 'mon', 'breakfast', 'dosa', 'uploads/600b56241244c0.20511127.jpg', 'BOYS_DINING', 1),
(2, 'mon', 'breakfast', 'idly', 'uploads/600b56241244c0.20511127.jpg', 'GIRLS_DINING', 1),
(3, 'sun', 'lunch', 'briyani', 'uploads/600b56241244c0.20511127.jpg', 'BOYS_DINING', 1),
(4, 'fri', 'breakfast', 'Dosa', 'uploads/600c562216f402.01834071.jpg', 'GIRLS_DINING', 1),
(5, 'sun', 'lunch', 'chilly chicken', 'uploads/600c7c43831381.25264297.jpg', 'BOYS_DINING', 1),
(6, 'mon', 'dinner', 'parotta', 'uploads/600de142f29f77.00647950.jpg', 'BOYS_DINING', 1),
(7, 'mon', 'dinner', 'chicken kuruma', 'uploads/600de1efe38350.56989006.jpg', 'BOYS_DINING', 1),
(8, 'mon', 'snacks', 'cake', 'uploads/600df0c5116f08.96237004.jpg', 'BOYS_DINING', 1),
(9, 'fri', 'dinner', 'chapathi', 'uploads/600df4c8779c09.39600575.jpg', 'BOYS_DINING', 1),
(10, 'fri', 'breakfast', 'tomato chutney', 'uploads/600df59b1161f6.29085837.jpg', 'BOYS_DINING', 1),
(11, 'mon', 'breakfast', 'Poori', 'uploads/601d395400ee47.53906846.jpg', 'BOYS_DINING', 1),
(12, 'mon', 'breakfast', 'porota', 'uploads/603c90d4e7a947.30957824.png', 'BOYS_DINING', 1),
(13, 'mon', 'breakfast', 'Saambar', 'uploads/60588377130076.93868227.jpg', 'BOYS_DINING', 1),
(14, 'mon', 'lunch', 'White rice', 'uploads/606159289cfe88.58582269.jpg', 'BOYS_DINING', 1),
(15, 'mon', 'lunch', 'Butter milk', 'uploads/60615953173b08.70373855.jpg', 'BOYS_DINING', 1),
(16, 'mon', 'lunch', 'Saambar', 'uploads/606159777a0d30.65236981.jpg', 'BOYS_DINING', 1),
(17, 'mon', 'lunch', 'Rasam', 'uploads/606159d435cf64.65227406.jpg', 'BOYS_DINING', 1),
(18, 'tue', 'lunch', 'Briyani', 'uploads/6062ccf9a138a9.37374628.jpg', 'BOYS_DINING', 1);

-- --------------------------------------------------------

--
-- Table structure for table `recipes_log_status`
--

CREATE TABLE `recipes_log_status` (
  `recipe_id` int(11) NOT NULL,
  `is_created` tinyint(1) NOT NULL,
  `action_by` varchar(50) NOT NULL,
  `action_logged_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recipes_log_status`
--

INSERT INTO `recipes_log_status` (`recipe_id`, `is_created`, `action_by`, `action_logged_at`) VALUES
(1, 1, 'super@admin.in', '2021-01-23 02:33:15'),
(2, 1, 'super@admin.in', '2021-01-23 02:34:01'),
(3, 1, 'admin@admin.in', '2021-01-23 04:18:04'),
(4, 1, 'super@admin.in', '2021-01-23 22:30:18'),
(5, 1, 'super@admin.in', '2021-01-24 01:12:59'),
(5, 0, 'super@admin.in', '2021-01-24 01:14:55'),
(6, 1, 'super@admin.in', '2021-01-25 02:36:11'),
(7, 1, 'bhuvi@gmail.com', '2021-01-25 02:39:04'),
(8, 1, 'super@admin.in', '2021-01-25 03:42:21'),
(9, 1, 'super@admin.in', '2021-01-25 03:59:28'),
(10, 1, 'super@admin.in', '2021-01-25 04:02:59'),
(11, 1, 'bhuvi@gmail.com', '2021-02-05 17:55:56'),
(12, 1, 'super@admin.in', '2021-03-01 12:29:32'),
(13, 1, 'super@admin.in', '2021-03-22 17:15:59'),
(14, 1, 'super@admin.in', '2021-03-29 10:05:52'),
(15, 1, 'super@admin.in', '2021-03-29 10:06:35'),
(16, 1, 'super@admin.in', '2021-03-29 10:07:11'),
(17, 1, 'super@admin.in', '2021-03-29 10:08:44'),
(18, 1, 'super@admin.in', '2021-03-30 12:32:17');

-- --------------------------------------------------------

--
-- Table structure for table `session_info`
--

CREATE TABLE `session_info` (
  `session` varchar(10) NOT NULL,
  `max_recipe_count` int(2) NOT NULL,
  `session_order` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session_info`
--

INSERT INTO `session_info` (`session`, `max_recipe_count`, `session_order`) VALUES
('breakfast', 15, 1),
('dinner', 15, 4),
('lunch', 15, 2),
('snacks', 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(80) NOT NULL,
  `role` varchar(11) NOT NULL,
  `venue` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_active` int(1) NOT NULL DEFAULT 0,
  `is_blocked` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `name`, `password`, `role`, `venue`, `created_at`, `is_active`, `is_blocked`) VALUES
('admin@admin.in', 'admin', '$2y$10$VGhpcyNJcyNNeSNIYXNoaO4m9T/GSTunGfgUtnD5cSHdd7M8TDgzS', 'ADMIN', 'ALL', '2021-01-24 21:06:47', 1, 0),
('ani@gmail.com', 'Anirudh', '$2y$10$aKzk5NBOXMM28s7rxph2rupVDDszPa3KCO4Dk1U/CM0WkvenSHX4u', 'ADMIN', 'ALL', '2021-03-01 12:26:00', 1, 0),
('aniruth@gmail.com', 'Aniruth', '$2y$10$KqjowbLyODuO/mulw5Q1F.fCzcV1TelpV9MLQs6lfEM1HystCX8d2', 'ADMIN', 'ALL', '2021-03-30 12:28:13', 1, 0),
('bhuvi@gmail.com', 'bhuvi', '$2y$10$VGhpcyNJcyNNeSNIYXNoaO4m9T/GSTunGfgUtnD5cSHdd7M8TDgzS', 'MANAGER', 'BOYS_DINING', '2021-01-24 21:04:03', 1, 0),
('suganth@gmai.com', 'suganth', '$2y$10$XAUXNq38Ag6YOuso1pEPluFLAxo3AIBcRMyaaR4GdIu869w84oZKG', 'MANAGER', 'BOYS_DINING', '2021-03-22 17:13:35', 1, 0),
('super@admin.in', 'Super Admin', '$2y$10$VGhpcyNJcyNNeSNIYXNoaO4m9T/GSTunGfgUtnD5cSHdd7M8TDgzS', 'SUPER_ADMIN', 'ALL', '2021-01-19 18:48:22', 1, 0),
('tony@gmail.com', 'tony', '$2y$10$VGhpcyNJcyNNeSNIYXNoaO4m9T/GSTunGfgUtnD5cSHdd7M8TDgzS', 'MANAGER', 'GIRLS_DINING', '2021-01-24 21:05:55', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_log_status`
--

CREATE TABLE `users_log_status` (
  `id` int(11) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `is_approved` int(1) NOT NULL,
  `action_by` varchar(50) NOT NULL,
  `action_logged_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_log_status`
--

INSERT INTO `users_log_status` (`id`, `user_email`, `is_approved`, `action_by`, `action_logged_at`) VALUES
(27, 'admin@admin.in', 1, 'super@admin.in', '2021-01-25 00:19:46'),
(28, 'bhuvi@gmail.com', 1, 'super@admin.in', '2021-01-25 00:19:50'),
(29, 'bhuvi@gmail.com', 0, 'super@admin.in', '2021-01-25 01:37:49'),
(30, 'bhuvi@gmail.com', 1, 'super@admin.in', '2021-01-25 01:37:59'),
(31, 'bhuvi@gmail.com', 0, 'super@admin.in', '2021-02-05 17:53:01'),
(32, 'bhuvi@gmail.com', 1, 'super@admin.in', '2021-02-05 17:54:36'),
(33, 'ani@gmail.com', 0, 'super@admin.in', '2021-03-01 12:27:45'),
(34, 'ani@gmail.com', 1, 'super@admin.in', '2021-03-01 12:27:52'),
(35, 'suganth@gmai.com', 1, 'super@admin.in', '2021-03-22 17:14:20'),
(36, 'tony@gmail.com', 1, 'super@admin.in', '2021-03-29 09:53:44'),
(37, 'tony@gmail.com', 0, 'super@admin.in', '2021-03-29 09:53:50'),
(38, 'aniruth@gmail.com', 1, 'super@admin.in', '2021-03-30 12:29:41'),
(39, 'tony@gmail.com', 1, 'super@admin.in', '2021-03-30 12:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `venue_info`
--

CREATE TABLE `venue_info` (
  `venue_id` varchar(20) NOT NULL,
  `venue_name` varchar(20) NOT NULL,
  `is_venue_available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `venue_info`
--

INSERT INTO `venue_info` (`venue_id`, `venue_name`, `is_venue_available`) VALUES
('BOYS_DINING', 'boys dining', 1),
('DAYSCHOLARS_DINING', 'dayscholars dining', 1),
('GIRLS_DINING', 'girls dining', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cook_item_waste`
--
ALTER TABLE `cook_item_waste`
  ADD PRIMARY KEY (`food_waste_id`);

--
-- Indexes for table `days_info`
--
ALTER TABLE `days_info`
  ADD PRIMARY KEY (`day_id`);

--
-- Indexes for table `days_session_info`
--
ALTER TABLE `days_session_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_wastes`
--
ALTER TABLE `food_wastes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session_info`
--
ALTER TABLE `session_info`
  ADD PRIMARY KEY (`session`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `users_log_status`
--
ALTER TABLE `users_log_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `venue_info`
--
ALTER TABLE `venue_info`
  ADD PRIMARY KEY (`venue_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `days_session_info`
--
ALTER TABLE `days_session_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `food_wastes`
--
ALTER TABLE `food_wastes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users_log_status`
--
ALTER TABLE `users_log_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
