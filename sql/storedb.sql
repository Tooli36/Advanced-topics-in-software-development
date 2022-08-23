-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2022 at 06:00 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `storedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_list`
--

CREATE TABLE `cart_list` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `catalog`
--

CREATE TABLE `catalog` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `img` text NOT NULL,
  `price` float NOT NULL,
  `availability` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `catalog`
--

INSERT INTO `catalog` (`id`, `name`, `description`, `img`, `price`, `availability`) VALUES
(1, 'Music Headphones', 'Great headphones to listen to music.', 'imgs/headphones.png', 180, 1),
(2, 'Silver Keyboard', 'Great Wired Keyboard for everyday use.', 'imgs/keyboard.png', 80, 1),
(3, '10\" Tablet', 'Great tablet for work and games.', 'imgs/tablet.png', 650, 0),
(4, 'PC Monitor', 'Great Computer Monitor with great colors and high resolution.', 'imgs/monitor.png', 700, 1),
(5, 'PC Red Mouse', 'Great mouse for everyday use.', 'imgs/mice.png', 70, 1),
(6, 'Lightweight Laptop', 'Great Lightweight laptop with long life battery, great keyboard.\r\nIdeal for students.', 'imgs/laptop.png', 2450, 1),
(7, 'Desktop Computer', 'Good Desktop computer.\r\ncomes with 21\" monitor\r\nmouse and keyboard.', 'imgs/desktop.png', 3400, 1),
(8, 'Printer', 'Great Color printer.', 'imgs/printer.png', 450, 1),
(9, 'All In One Computer', 'Desktop computer inside the monitor.\r\ncomes with keyboard and mouse.', 'imgs/all_in_one.png', 4500, 1),
(10, 'Computer Speakers', 'Classic Speakers for Computer.', 'imgs/speakers.png', 90, 1),
(11, 'Game Controller', 'Great game controller for pc and console.', 'imgs/controller.png', 200, 1),
(12, 'DiskOnKey 64GB', 'fast diskonkey with 64gb storage.', 'imgs/flashdrive.png', 40, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `sum` float NOT NULL,
  `city` text NOT NULL,
  `address` text NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `phone` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `description`, `sum`, `city`, `address`, `firstname`, `lastname`, `phone`, `status`) VALUES
(31, 10, 'Lightweight Laptop (2450₪),PC Monitor (700₪)', 3150, 'city', 'address ', 'first', 'last', '0123456789', 0),
(32, 10, 'Silver Keyboard (80₪),PC Red Mouse (70₪),Lightweight Laptop (2450₪)', 2600, 'city', 'address ', 'first', 'last', '0123456789', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `phone` text NOT NULL,
  `city` text NOT NULL,
  `address` text NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `phone`, `city`, `address`, `firstname`, `lastname`, `admin`) VALUES
(10, 'admin@admin.com', 'e10adc3949ba59abbe56e057f20f883e', '0123456789', 'city', 'address ', 'first', 'last', 1),
(11, 'user@user.com', 'e10adc3949ba59abbe56e057f20f883e', '0123456789', 'city', 'adress', 'user', 'user', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_list`
--
ALTER TABLE `cart_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_list`
--
ALTER TABLE `cart_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
