-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 09:55 AM
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
-- Database: `inventory`
--

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `ref_no`, `name`) VALUES
(29, 'cust1001', 'Alice Johnson'),
(30, 'cust1002', 'Bob Smith'),
(31, 'cust1003', 'Charlie Brown');

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `invoice_name`, `customer_id`, `tanggal`) VALUES
(36, 'inv1001', 29, '2025-04-25'),
(37, 'inv1002', 30, '2025-04-26');

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `item_id`, `harga`, `jumlah`, `total_harga`, `total`) VALUES
(69, 36, 44, 8500000, 1, 8500000, NULL),
(70, 36, 45, 550000, 2, 1100000, NULL),
(71, 37, 46, 2500000, 1, 2500000, NULL);

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `ref_no`, `name`, `price`) VALUES
(44, 'item1001', 'Laptop ABC', 8500000.00),
(45, 'item1002', 'Keyboard XYZ', 550000.00),
(46, 'item1003', 'Monitor DEF', 2500000.00);

--
-- Dumping data for table `item_customer`
--

INSERT INTO `item_customer` (`id`, `item_id`, `customer_id`, `harga`) VALUES
(15, 44, 29, 8000000),
(16, 45, 29, 500000),
(17, 46, 30, 2400000);

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `ref_no`, `name`) VALUES
(18, 'supp1001', 'Supplier A'),
(19, 'supp1002', 'Supplier B');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
