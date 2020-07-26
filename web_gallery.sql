-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 10 юни 2020 в 01:15
-- Версия на сървъра: 10.4.11-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_gallery`
--

CREATE DATABASE IF NOT EXISTS web_gallery DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE web_gallery;
-- --------------------------------------------------------

--
-- Структура на таблица `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `albums` (`id`, `name`, `description`, `createdAt`, `userId`) VALUES
(1, 'Test Album', 'This is a test album', '2020-07-21 20:31:34', 1),
(2, 'Second Test', 'This is another test album', '2020-07-21 20:32:39', 1);

-- --------------------------------------------------------

--
-- Структура на таблица `album_images`
--

CREATE TABLE `album_images` (
  `id` int(11) NOT NULL,
  `image_instance_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `album_images` (`id`, `image_instance_id`, `album_id`) VALUES
(1, 9, 1),
(2, 8, 1),
(3, 3, 1),
(4, 5, 2),
(5, 4, 2);

-- --------------------------------------------------------

--
-- Структура на таблица `images`
--

CREATE TABLE `images` (
  `path` varchar(2048) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `device` varchar(255) DEFAULT NULL,
  `filesize` float DEFAULT NULL,
  `number_instances` int(11) NOT NULL DEFAULT 0,
  `id` int(11) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `gps_longitude` float(7,4) DEFAULT NULL,
  `gps_latitude` float(7,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `images` (`path`, `timestamp`, `device`, `filesize`, `number_instances`, `id`, `original_filename`, `author`, `description`, `geoposition`) VALUES
('Chrysanthemum_5f174d9829225.jpg', '2020-07-14 11:59:26', NULL, 879394, 1, 15, 'Chrysanthemum.jpg', '', '', NULL),
('Hydrangeas_5f174da2e5207.jpg', '2020-06-24 14:41:53', NULL, 595284, 1, 16, 'Hydrangeas.jpg', '', '', NULL),
('Desert_5f174dc478022.jpg', '2020-06-14 11:59:26', NULL, 845941, 1, 17, 'Desert.jpg', '', '', NULL),
('Penguins_5f174dcd791c4.jpg', '2019-07-22 03:07:31', NULL, 777835, 1, 18, 'Penguins.jpg', '', '', NULL),
('Koala_5f174dd61ec81.jpg', '2019-07-22 09:32:43', NULL, 780831, 1, 19, 'Koala.jpg', '', '', NULL),
('Lighthouse_5f174ddfea854.jpg', '2020-07-11 09:32:51', NULL, 561276, 1, 20, 'Lighthouse.jpg', '', '', NULL),
('Tulips_5f174de637144.jpg', '2020-07-07 09:33:11', NULL, 620888, 1, 21, 'Tulips.jpg', '', '', NULL);

-- --------------------------------------------------------

--
-- Структура на таблица `image_instances`
--

CREATE TABLE `image_instances` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `image_instances` (`id`, `user_id`, `image_id`) VALUES
(3, 1, 15),
(4, 1, 16),
(5, 1, 17),
(6, 1, 18),
(7, 1, 19),
(8, 1, 20),
(9, 1, 21);

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `password` longtext NOT NULL,
  `date_registered` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `date_registered`) VALUES
(1, 'test_user', 'alex_yovkova@abv.bg', '$2y$10$iRUbwBh/Q.lpoh9k4uRmG.wiXDdyh3bg7WfNdfcZhhG0i.cZwrt.C', '2020-06-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `album_images`
--
ALTER TABLE `album_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `album_id` (`album_id`),
  ADD KEY `image_instance_id` (`image_instance_id`) USING BTREE;

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `imagePath` (`path`) USING HASH;

--
-- Indexes for table `image_instances`
--
ALTER TABLE `image_instances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING HASH,
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `image_instances`
--
ALTER TABLE `image_instances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `album_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения за дъмпнати таблици
--

--
-- Ограничения за таблица `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Ограничения за таблица `album_images`
--
ALTER TABLE `album_images`
  ADD CONSTRAINT `album_images_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `album_images_ibfk_2` FOREIGN KEY (`image_instance_id`) REFERENCES `image_instances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `image_instances`
--
ALTER TABLE `image_instances`
  ADD CONSTRAINT `image_instances_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `image_instances_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE `images` CHANGE `timestamp` `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;