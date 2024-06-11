-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2023 at 04:43 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `semesterproject`
--

-- --------------------------------------------------------







CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `anrede` varchar(10) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 0,
  `status` varchar(200) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `email`, `anrede`, `password`, `role`, `status`) VALUES
(12, 'Test', 'User21', 'TestUser', 'testuser21@gmail.com', 'Mr', '$2y$10$RhnnlzC7qM5MDRVzTxJulOLbhW0t.bDwWJ3MNk2NeGvqlkxj4Yl0.', 0, '0'),
(13, 'Test212', 'User212', '', 'testuser221@gmail.com', 'Mrs', '$2y$10$tdihb7GcOAK0KDshh2yP.eEoy.lkOsPxgenhOStNvhpZJHU6TOwIi', 0, '0'),
(15, 'testtt', 'TESTTTT', 'test21', 'test@gmail.com', 'Mrs', '$2y$10$tgcUJqaTzKbqe/maufOMQeIU0tHG3pkfxqYxJch1t84eak9IdxXSy', 0, '0'),
(16, 'Test21', 'User21222', '', 'testuser21@gmail.com', 'Mrs', '$2y$10$vkFCPLOWLymDBPwXXEydw.FlKn3NpEcO84TdjaEttA6Ox83oUKA5i', 1, '0'),
(17, 'Inactive', 'User', 'InactiveUs', 'inactive@gmail.com', 'Mr', '$2y$10$HXrc3GxqdcDqo5vjB59RW.17hFRO1.Y1sP6A0I1JRQNmR7lWY3J7u', 0, 'Inactive'),
(18, 'drferf', 'cefrfe', 'pppp', 'erwer@dwedf.com', 'Other', '$2y$10$VPFq90y6mV7z71oUYVpNTuTgpPuNkW8aZargQagsRaaAsaU9Gzu8i', 1, 'Active'),
(20, 'Admin', 'User', 'AdminUser', 'adm@gmail.com', 'Mrs', '$2y$10$Y.yUHzLOpDya8zAyHrXC7euIIxyS5WUXpGm54uZhpG3LDyzNULzkm', 1, 'Active'),
(21, 'livia', 'zylja', 'liviazylja', 'livia@gmail.com', 'Mrs', '$2y$10$XwFe9naG.HJcsAZwAiK2He8ASGfAzGtJUPnxxNl3oQoSp5dGv40nm', 0, 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservation`
--
--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);


--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
CREATE TABLE `basket` (
    `itemId` int(10) NOT NULL,
    `itemName` varchar(50) NOT NULL,
    `itemPrice` varchar(10) NOT NULL,
    `itemImage` varchar(100) NOT NULL,
    `typeName` varchar(50) NOT NULL,
    `size` varchar(10) NOT NULL,
    `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `basket`
  ADD PRIMARY KEY (`itemId`);


CREATE TABLE `produkte` (
  `itemId` INT(10) NOT NULL AUTO_INCREMENT,
  `itemName` VARCHAR(50) NOT NULL,
  `itemPrice` VARCHAR(10) NOT NULL,
  `itemImage` VARCHAR(100) NOT NULL,
  `itemDescription` VARCHAR(1000) NOT NULL,
  `typeName` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
INSERT INTO `produkte` (`itemId`, `itemName`, `itemPrice`, `itemImage`, `itemDescription`, `typeName`)
VALUES
(1, 'Balenciaga x adidas Sneakkers', '879.99', 'blue.webp', 'Great, premium Sneakers', 'sneakers'),
(2, 'Sneakers Nike', '109.99', 'sneaker.webp', 'Comfortable 100% cotton sneakers', 'sneakers'),
(3, 'Nike bag All Star', '29.99', 'bag.png', 'nike gym bag', 'bag'),
(4, 'Nike T-Shirt ', '19.99', 'gallery2.png', 'Great T-Shirt', 'cloth');

-- Create the purchased table
CREATE TABLE purchased (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    size VARCHAR(10) NOT NULL,
    category VARCHAR(50) NOT NULL,
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tracking_code VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES user(id)
);

-- Insert sample records into the purchased table
INSERT INTO purchased (user_id, name, price, image, size, category, tracking_code) VALUES
(1, 'Balenciaga x adidas Sneakers', 880.00, 'blue.webp', 'S', 'brand', 'TRK1A2B3C4D'),
(1, 'The North Face x Supreme', 1880.00, 'TNF.png', 'M', 'brand', 'TRK5E6F7G8H'),
(1, 'Nike T-Shirt', 20.00, 'image55.png', 'L', 'regular', 'TRK9I0J1K2L'),
(2, 'Nike Jordan Pro Max', 160.00, 'image55.png', 'XL', 'regular', 'TRKM3N4O5P6');
