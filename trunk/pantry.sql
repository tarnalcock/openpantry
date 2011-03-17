-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 24, 2010 at 04:45 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pantry`
--

-- --------------------------------------------------------

--
-- Table structure for table `aid`
--

CREATE TABLE IF NOT EXISTS `aid` (
  `aidid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `usda_qualifier` tinyint(1) NOT NULL,
  PRIMARY KEY (`aidid`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `bag`
--

CREATE TABLE IF NOT EXISTS `bag` (
  `bagid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`bagid`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Table structure for table `bag_to_food_source`
--

CREATE TABLE IF NOT EXISTS `bag_to_food_source` (
  `sourceid` int(10) unsigned NOT NULL,
  `bagid` int(10) unsigned NOT NULL,
  `weight` float NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`sourceid`,`bagid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bag_to_product`
--

CREATE TABLE IF NOT EXISTS `bag_to_product` (
  `bagid` int(10) unsigned NOT NULL,
  `productid` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `choice` tinyint(1) NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`bagid`,`productid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `clientid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `familyid` int(10) unsigned DEFAULT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `dob` date NOT NULL,
  PRIMARY KEY (`clientid`),
  KEY `familyid` (`familyid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=530 ;

-- --------------------------------------------------------

--
-- Table structure for table `family`
--

CREATE TABLE IF NOT EXISTS `family` (
  `clientid` int(10) unsigned NOT NULL,
  `bagid` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL,
  `address` text NOT NULL,
  `telephone` varchar(16) NOT NULL,
  `fuel_assistance` tinyint(1) NOT NULL,
  `usda_assistance` tinyint(1) NOT NULL,
  `delivery` tinyint(1) NOT NULL,
  `dietary` tinyint(1) NOT NULL,
  `pickup_second` tinyint(1) NOT NULL,
  `pickup_fourth` tinyint(1) NOT NULL,
  `cooking_facilities` tinyint(1) NOT NULL,
  `start_date` date NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`clientid`),
  KEY `bagid` (`bagid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `family_to_aid`
--

CREATE TABLE IF NOT EXISTS `family_to_aid` (
  `clientid` int(10) unsigned NOT NULL,
  `aidid` int(10) unsigned NOT NULL,
  `amount` float NOT NULL,
  PRIMARY KEY (`clientid`,`aidid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `food_source`
--

CREATE TABLE IF NOT EXISTS `food_source` (
  `sourceid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`sourceid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `productid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`productid`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `transactionid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clientid` int(10) unsigned DEFAULT NULL,
  `delivery` bit(1) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`transactionid`),
  KEY `clientid` (`clientid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_to_food_source`
--

CREATE TABLE IF NOT EXISTS `transaction_to_food_source` (
  `transactionid` int(10) unsigned NOT NULL,
  `sourceid` int(10) unsigned NOT NULL,
  `weight` float NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`transactionid`,`sourceid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` char(32) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `access` int(2) unsigned NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
