-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2017 at 12:53 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sk salon`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminportal`
--

CREATE TABLE `adminportal` (
  `Stylists` text NOT NULL,
  `AboutUs` text NOT NULL,
  `Services` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `siteuser`
--

CREATE TABLE `siteuser` (
  `id` int(11) NOT NULL,
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `userID` varchar(128) NOT NULL,
  `password` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siteuser`
--

INSERT INTO `siteuser` (`id`, `firstName`, `lastName`, `userID`, `password`) VALUES
(1, 'Sandee', 'Kranz', 'skadmin', 'salon'),
(2, 'a', 'a', 'a', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `stylists`
--

CREATE TABLE `stylists` (
  `Title` text NOT NULL,
  `Text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stylists`
--

INSERT INTO `stylists` (`Title`, `Text`) VALUES
('Sandee Kranz', 'Sandee Kranz, owner of The SK Salon, has been working as a hair stylist for ___ years. 	A graduate of Paul Mitchell The School Huntsville, Sandee worked at Bangs Salon, The Stile Salon as Master Stylist, and now as an independent stylist for The SK Salon in New Beginnings Salon and	Trading Post located in Athens, AL.'),
('Lorem Ipsum', 'Lorem ipsum dolor sit amet, lobortis phasellus enim, sed vestibulum volutpat tellus condimentum sed sed, ante sit proin consequat amet ultrices, arcu bibendum scelerisque. Aenean fames, viverra a in, libero elementum ac gravida vulputate vitae, sem ipsum wisi lorem dolor tristique in, pede elit est eu luctus. Inceptos erat. Cubilia id metus accumsan eu, commodo commodo vel, nisl in, elementum ac, neque ac posuere velit. Blandit in erat nunc eleifend. Scelerisque montes wisi mi.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `siteuser`
--
ALTER TABLE `siteuser`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `siteuser`
--
ALTER TABLE `siteuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
