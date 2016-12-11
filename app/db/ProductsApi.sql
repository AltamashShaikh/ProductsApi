-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 12, 2016 at 03:45 AM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ProductsApi`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `image` varchar(500) NOT NULL,
  `image_256` varchar(500) NOT NULL,
  `image_512` varchar(500) NOT NULL,
  `price` bigint(20) NOT NULL,
  `creation_date` date NOT NULL,
  `updation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `image`, `image_256`, `image_512`, `price`, `creation_date`, `updation_date`, `is_deleted`) VALUES
(1, 'testabc', 'http://localhost.productsapi/img/product_images_1481479749_2c012_actual_image.jpeg', 'http://localhost.productsapi/img/product_images_1481479749_2c012_256_pixel_image.jpeg', 'http://localhost.productsapi/img/product_images_1481479749_2c012_512_pixel_image.jpeg', 400, '2016-12-12', '2016-12-11 21:47:27', 0),
(2, 'Testtyyy', 'http://localhost.productsapi/img/product_images_1481479749_2c012_actual_image.jpeg', 'http://localhost.productsapi/img/product_images_1481479749_2c012_256_pixel_image.jpeg', 'http://localhost.productsapi/img/product_images_1481479749_2c012_512_pixel_image.jpeg', 400, '2016-12-12', '2016-12-11 21:53:57', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
