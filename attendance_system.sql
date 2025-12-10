-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2024 at 03:23 PM
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
-- Database: `attendance_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `profilepic` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `bio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `profilepic`, `first_name`, `last_name`, `email`, `bio`) VALUES
(8, 'ecebbecf28c2692aeb021597fbddb174.jpg', 'Lili', 'Susanti', 'lilisusanti@gmail.com', 'Hi!'),
(10, '68d5535b971d558f594f10a5affd0a71jpeg', 'Vina', 'Sumarti', 'vinasumarti@gmail.com', 'Hai semua');

-- --------------------------------------------------------

--
-- Table structure for table `userss`
--

CREATE TABLE `userss` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `userss`
--

INSERT INTO `userss` (`id`, `username`, `email`, `password`, `name`) VALUES
(4, 'sasa', 'sasarisa@gmail.com', '$2y$10$IFGSL681/rAh68aGNP8wrOl/.nBHQXbqvepo5UFaosS9mlQQu/2pW', 'sasa'),
(14, 'rara', 'raranina@gmail.com', '$2y$10$ONIvkhbgXR0XyCb.boreoekBtCEpH/HntG/8vGJk2M76k44W3AdYu', 'rara'),
(16, 'nana', 'nanagwen@gmail.com', '$2y$10$5XmKiIsUc6A6KdS8FI7c2Ovs0XPjMndATds/8HguzAshycUaRJu6W', 'nana'),
(37, 'Lala', 'lalali@gmail.com', '$2y$10$1z4iu0JlL7uE44Z0IxYgm.vxGrJDTUG3vJm5/UTXPYU4blKgFEKw6', 'Lalisa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userss`
--
ALTER TABLE `userss`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `userss`
--
ALTER TABLE `userss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
