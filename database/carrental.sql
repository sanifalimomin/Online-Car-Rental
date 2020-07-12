-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2020 at 03:22 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carrental`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(20) NOT NULL,
  `car_name` varchar(50) NOT NULL,
  `car_nameplate` varchar(50) NOT NULL,
  `car_img` varchar(50) DEFAULT 'NA',
  `ac_price` float NOT NULL,
  `non_ac_price` float NOT NULL,
  `ac_price_per_day` float NOT NULL,
  `non_ac_price_per_day` float NOT NULL,
  `car_availability` varchar(10) NOT NULL,
  `client` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `car_name`, `car_nameplate`, `car_img`, `ac_price`, `non_ac_price`, `ac_price_per_day`, `non_ac_price_per_day`, `car_availability`, `client`) VALUES
(1, 'Wagon R', 'KA19MG9910', 'assets/img/cars/wagon-r.png', 10, 8, 2000, 1600, 'no', 'sanifalimomin'),
(3, 'Innova', 'GA16NM9125', 'assets/img/cars/Innova.png', 13, 11, 2600, 2200, 'yes', 'sanifalimomin'),
(4, 'Ford Figo', 'GJ17HZ4001', 'assets/img/cars/figo.png', 11, 9, 2200, 1800, 'yes', 'sanifalimomin'),
(9, 'Swift Dzire', 'BR01HX8001', 'assets/img/cars/dzire.png', 10, 8, 2000, 1600, 'yes', 'sanifalimomin'),
(10, 'Suzuki Ciaz', 'TN17MS1997', 'assets/img/cars/Suzuki_Ciaz_2017.jpg', 12, 10, 2400, 2000, 'yes', 'sanifalimomin'),
(12, 'Toyota Fortuner', 'GA08MX1997', 'assets/img/cars/Fortuner.png', 16, 14, 3200, 2800, 'yes', 'sanifalimomin'),
(13, 'Suzuki Ertiga', 'MH02DC1997', 'assets/img/cars/maruti-suzuki-ertiga.jpg', 14, 12, 2800, 2400, 'yes', 'sanifalimomin'),
(14, 'Corolla', 'BK5-768', 'assets/img/cars/corolla.jpg', 300, 200, 8000, 5000, 'yes', 'sanifalimomin'),
(15, 'Mercedes', 'PKI-123', 'assets/img/cars/merc.png', 1000, 800, 35000, 28000, 'yes', 'sanifalimomin'),
(22, 'Alto 800', 'ABC-1978', 'assets/img/cars/alto-800.png', 300, 200, 8000, 5000, 'yes', 'sanifalimomin'),
(23, 'BWM', 'bmw-179', 'assets/img/cars/bmw.jpg', 1500, 1000, 30000, 25000, 'yes', 'sanifalimomin');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_username` varchar(50) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `client_phone` varchar(15) NOT NULL,
  `client_email` varchar(25) NOT NULL,
  `client_address` varchar(50) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `client_password` varchar(32) NOT NULL,
  `pass_code` varchar(32) DEFAULT NULL,
  `auth` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_username`, `client_name`, `client_phone`, `client_email`, `client_address`, `client_password`, `pass_code`, `auth`) VALUES
('sanifali', 'sanifali', '0123456789', 'k163966@nu.edu.pk', 'abcd-karachi', '4874e68ae7171fb6a3e2a90ffca1b6a4', '90f4760fcc9b69c13da7368c5c2917f3', 'Yes'),
('sanifalimomin', 'sanifalimomin', '0123456789', 'sanifalimomin@gmail.com', 'mkakcnsdnvmknk knsdk', '4874e68ae7171fb6a3e2a90ffca1b6a4', 'd83df0d58637d4fca2d52dcdbb3ccb4f', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_username` varchar(50) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `customer_email` varchar(25) NOT NULL,
  `customer_address` varchar(50) NOT NULL,
  `customer_password` varchar(32) NOT NULL,
  `pass_code` varchar(32) DEFAULT NULL,
  `auth` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_username`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`, `customer_password`, `pass_code`, `auth`) VALUES
('ali', 'sad', '1561315616', 'sanif@gmail.com', 'cafsd', '31d4541b8e926a24f0c9b835b68cfdf3', '38333', 'Yes'),
('sanifaa', 'sdsa', '1561315616', 'aaaaaaaaaa@gmail.com', 'abcd- karachi', '31d4541b8e926a24f0c9b835b68cfdf3', '020c8bfac8de160d4c5543b96d1fdede', 'No'),
('sanifali', 'sanifali', '1561315616', 'k163966@nu.edu.pk', 'abcd- karachi', '31d4541b8e926a24f0c9b835b68cfdf3', 'd9ff90f4000eacd3a6c9cb27f78994cf', 'Yes'),
('sanifalimomin', 'sanif', '03352153303', 'sanifalimomin@gmail.com', 'abcd- karachi', '31d4541b8e926a24f0c9b835b68cfdf3', '56352739f59643540a3a6e16985f62c7', 'Yes'),
('sanifalimomina', 'Ali', '03352153303', 'ali@gmail.com', 'abcd- karachi', '31d4541b8e926a24f0c9b835b68cfdf3', 'd563cb0699fbe7bc92d64815915918cd', 'Yes'),
('sfasfasd', 'sdsa', '1561315616', 'aaaaaaa@gmail.com', 'cafsd', '31d4541b8e926a24f0c9b835b68cfdf3', '003dd617c12d444ff9c80f717c3fa982', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `driver_id` int(20) NOT NULL,
  `driver_name` varchar(50) NOT NULL,
  `dl_number` int(50) NOT NULL,
  `driver_phone` int(15) NOT NULL,
  `driver_address` varchar(50) NOT NULL,
  `driver_gender` varchar(10) NOT NULL,
  `client_username` varchar(50) NOT NULL,
  `driver_availability` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`driver_id`, `driver_name`, `dl_number`, `driver_phone`, `driver_address`, `driver_gender`, `client_username`, `driver_availability`) VALUES
(1, 'Ali', 1202982658, 2147483647, 'my home', 'male', 'sanifalimomin', 'yes'),
(5, 'Ali', 324234423, 2147483647, 'my home', 'Male', 'sanifalimomin', 'yes'),
(7, 'sanif', 1286598, 2147483647, 'my home', 'Male', 'sanifalimomin', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `name` varchar(20) NOT NULL,
  `e_mail` varchar(30) NOT NULL,
  `message` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`name`, `e_mail`, `message`) VALUES
('abc', 'abc@gmail.com', 'Hope this works.'),
('sanif', 'sa', 'sdafas'),
('sanif', 'sa', 'sdafas'),
('', '', ''),
('sanif', 'sa', 'sdafas'),
('staff', 'sa@gmail.com', 'sfddasfw');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `name` varchar(20) NOT NULL,
  `e_mail` varchar(30) NOT NULL,
  `message` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`name`, `e_mail`, `message`) VALUES
('sdaf', 'sa@gmail.com', 'sadasfdweascweascs'),
('sdaf', 'sa@gmail.com', 'sadasfdweascweascs'),
('sdaf', 'sa@gmail.com', 'sadasfdweascweascs');

-- --------------------------------------------------------

--
-- Table structure for table `rentedcars`
--

CREATE TABLE `rentedcars` (
  `id` int(100) NOT NULL,
  `customer_username` varchar(50) NOT NULL,
  `car_id` int(20) NOT NULL,
  `driver_id` int(20) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `rent_start_date` date NOT NULL,
  `rent_end_date` date NOT NULL,
  `fare` double NOT NULL,
  `charge_type` varchar(25) NOT NULL DEFAULT 'days',
  `return_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rentedcars`
--

INSERT INTO `rentedcars` (`id`, `customer_username`, `car_id`, `driver_id`, `booking_date`, `rent_start_date`, `rent_end_date`, `fare`, `charge_type`, `return_status`) VALUES
(31, 'sanifalimomin', 1, NULL, '2020-06-24', '2020-06-24', '2020-06-25', 2000, 'days', 'NR');

-- --------------------------------------------------------

--
-- Table structure for table `returncars`
--

CREATE TABLE `returncars` (
  `id` int(11) NOT NULL,
  `customer_username` varchar(50) NOT NULL,
  `car_id` int(20) NOT NULL,
  `driver_id` int(20) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `rent_start_date` date NOT NULL,
  `rent_end_date` date NOT NULL,
  `fare` double NOT NULL,
  `charge_type` varchar(25) NOT NULL,
  `distance` double DEFAULT NULL,
  `no_of_days` int(50) NOT NULL,
  `total_amount` double NOT NULL,
  `return_status` varchar(10) NOT NULL,
  `car_return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `returncars`
--

INSERT INTO `returncars` (`id`, `customer_username`, `car_id`, `driver_id`, `booking_date`, `rent_start_date`, `rent_end_date`, `fare`, `charge_type`, `distance`, `no_of_days`, `total_amount`, `return_status`, `car_return_date`) VALUES
(1, 'sanifalimomin', 15, 1, '2020-06-14', '2020-06-16', '2020-06-17', 1000, 'km', 18, 1, 18000, 'R', '2020-06-17'),
(8, 'sanifalimomin', 10, 0, '2020-06-14', '2020-06-14', '2020-06-15', 12, 'km', 50, 1, 600, 'R', '0000-00-00'),
(9, 'sanifalimomin', 1, 0, '0000-00-00', '2020-06-16', '2020-06-16', 10, 'km', NULL, 0, 0, 'C', '0000-00-00'),
(10, 'sanifalimomin', 4, 0, '2020-06-14', '2020-06-17', '2020-06-18', 11, 'km', NULL, 0, 0, 'C', '0000-00-00'),
(11, 'sanifalimomin', 3, 0, '2020-06-15', '2020-06-16', '2020-06-17', 2600, 'days', NULL, 0, 0, 'C', '2020-06-15'),
(12, 'sanifalimomin', 9, 7, '2020-06-15', '2020-06-15', '2020-06-15', 10, 'km', 10, 0, 100, 'R', '2020-06-15'),
(13, 'sanifalimomin', 15, 0, '2020-06-15', '2020-06-15', '2020-06-15', 35000, 'days', NULL, 0, 9000, 'R', '2020-06-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD UNIQUE KEY `car_nameplate` (`car_nameplate`),
  ADD KEY `client` (`client`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_username`),
  ADD UNIQUE KEY `client_email` (`client_email`),
  ADD UNIQUE KEY `pass_code` (`pass_code`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_username`),
  ADD UNIQUE KEY `customer_email` (`customer_email`),
  ADD UNIQUE KEY `pass_code` (`pass_code`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`driver_id`),
  ADD UNIQUE KEY `dl_number` (`dl_number`),
  ADD UNIQUE KEY `dl_number_2` (`dl_number`),
  ADD KEY `client_username` (`client_username`);

--
-- Indexes for table `rentedcars`
--
ALTER TABLE `rentedcars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_username` (`customer_username`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `returncars`
--
ALTER TABLE `returncars`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `driver_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rentedcars`
--
ALTER TABLE `rentedcars`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `returncars`
--
ALTER TABLE `returncars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`client`) REFERENCES `clients` (`client_username`);

--
-- Constraints for table `driver`
--
ALTER TABLE `driver`
  ADD CONSTRAINT `driver_ibfk_1` FOREIGN KEY (`client_username`) REFERENCES `clients` (`client_username`);

--
-- Constraints for table `rentedcars`
--
ALTER TABLE `rentedcars`
  ADD CONSTRAINT `rentedcars_ibfk_1` FOREIGN KEY (`customer_username`) REFERENCES `customers` (`customer_username`),
  ADD CONSTRAINT `rentedcars_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`),
  ADD CONSTRAINT `rentedcars_ibfk_3` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`driver_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
