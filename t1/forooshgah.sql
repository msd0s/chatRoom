-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2022 at 08:08 AM
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
-- Database: `forooshgah`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `branch_name` varchar(70) COLLATE utf8_persian_ci NOT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  `city` varchar(40) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branch_name`, `create_date`, `city`) VALUES
(1, 'فروشگاه قلهک-۲۷۰۸۱', '2022-08-01 08:50:08', 'mashhad'),
(2, 'فروشگاه میرداماد-۲۷۰۱۱', '2022-08-02 08:50:08', 'mashhad'),
(3, 'اختیاریه جنوبی-مارکت دلپسند ۲۷۱۳۱', '2022-08-01 08:56:12', 'esfahan'),
(4, 'فروشگاه پارک رویال-۲۷۱۵۱', '2022-08-02 08:56:12', 'esfahan');

-- --------------------------------------------------------

--
-- Table structure for table `branch_units`
--

CREATE TABLE `branch_units` (
  `id` int(11) NOT NULL,
  `unit_name` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `unit_description` text COLLATE utf8_persian_ci DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `branch_units`
--

INSERT INTO `branch_units` (`id`, `unit_name`, `unit_description`, `branch_id`) VALUES
(1, 'foroosh', NULL, 3),
(2, 'foroosh', NULL, 4),
(3, 'hesabdari', NULL, 3),
(4, 'hesabdari', NULL, 4),
(5, 'tadarokat', NULL, 1),
(6, 'tadarokat', NULL, 2),
(7, 'tadarokat', NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `personaly_id` int(11) NOT NULL,
  `person_name` varchar(80) COLLATE utf8_persian_ci NOT NULL,
  `person_age` tinyint(4) NOT NULL,
  `salary` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`personaly_id`, `person_name`, `person_age`, `salary`, `unit_id`) VALUES
(100010, 'haj mohammad hasan chamandargheych zade', 101, 1500, 1),
(100011, 'mohammad mirza taghi khan mirzajani', 80, 950, 1),
(100012, 'haj abdollah mirza khajezade', 100, 1200, 1),
(100013, 'mohammad entezari', 75, 1100, 1),
(100014, 'hamid reza eftekhari', 95, 1050, 1),
(100015, 'haj mohammad ebrahim chamandargheychi', 101, 1500, 1),
(100016, 'mohammad dorani', 110, 1250, 2),
(100017, 'haj ali esmaeili', 25, 750, 2),
(100018, 'masood talebian', 35, 1700, 3),
(100019, 'saeed azaryan', 29, 2500, 3),
(100020, 'zahra goldokht', 26, 1450, 5),
(100021, 'mohammad raeisi', 70, 650, 5),
(100022, 'zohre noori', 18, 3000, 1),
(100023, 'hassan allahyari', 28, 1200, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_units`
--
ALTER TABLE `branch_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_branch_id` (`branch_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`personaly_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `branch_units`
--
ALTER TABLE `branch_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branch_units`
--
ALTER TABLE `branch_units`
  ADD CONSTRAINT `FK_branch_id` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `FK_unit_id` FOREIGN KEY (`unit_id`) REFERENCES `branch_units` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
