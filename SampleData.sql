-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2016 at 11:54 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `symfony`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
`id` int(11) NOT NULL,
  `state_id_id` int(11) DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `state_id_id`, `city`) VALUES
(1, 1, 'Hamburg'),
(2, 2, 'Bremen'),
(3, 3, 'Somme'),
(4, 3, 'Amiens'),
(5, 4, 'Rennes'),
(6, 4, 'Brest');

-- --------------------------------------------------------

--
-- Table structure for table `city_area`
--

CREATE TABLE IF NOT EXISTS `city_area` (
`id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `CityArea` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Dumping data for table `city_area`
--

INSERT INTO `city_area` (`id`, `city_id`, `CityArea`) VALUES
(13, 1, 'Hamburg Area 1'),
(14, 1, 'Hamburg Area 2'),
(15, 2, 'Bremen Area 1'),
(16, 2, 'Bremen Area 2'),
(17, 3, 'Somme Area 3'),
(18, 3, 'Somme Area 2'),
(19, 4, 'Amiens Area 1'),
(20, 4, 'Amiens Area 2'),
(21, 5, 'Rennes Area 1'),
(22, 5, 'Rennes Area 1'),
(23, 6, 'Brest Area 2');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
`id` int(11) NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `country`) VALUES
(1, 'Germany'),
(2, 'France');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
`id` int(11) NOT NULL,
  `country_id_id` int(11) DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `country_id_id`, `state`) VALUES
(1, 1, 'Hamburg'),
(2, 1, 'Bremen'),
(3, 2, 'Picardy'),
(4, 2, 'Brittany');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_2D5B0234DD71A5B` (`state_id_id`);

--
-- Indexes for table `city_area`
--
ALTER TABLE `city_area`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_34DA00008BAC62AF` (`city_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_A393D2FBD8A48BBD` (`country_id_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `city_area`
--
ALTER TABLE `city_area`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `city`
--
ALTER TABLE `city`
ADD CONSTRAINT `FK_2D5B0234DD71A5B` FOREIGN KEY (`state_id_id`) REFERENCES `state` (`id`);

--
-- Constraints for table `city_area`
--
ALTER TABLE `city_area`
ADD CONSTRAINT `FK_34DA00008BAC62AF` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

--
-- Constraints for table `state`
--
ALTER TABLE `state`
ADD CONSTRAINT `FK_A393D2FBD8A48BBD` FOREIGN KEY (`country_id_id`) REFERENCES `country` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
