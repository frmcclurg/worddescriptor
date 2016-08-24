-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql207.byethost11.com
-- Generation Time: Aug 24, 2016 at 03:03 PM
-- Server version: 5.6.31-77.0
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `b11_17022837_words`
--

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE IF NOT EXISTS `guest` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key of guest',
  `name` varchar(30) NOT NULL COMMENT 'First and last name of guest',
  `friend_first` varchar(20) NOT NULL,
  `friend_last` varchar(20) NOT NULL,
  `notes` text COMMENT 'Optional notes of guest',
  `ip_address` varchar(15) DEFAULT NULL COMMENT 'IP address of guest',
  `browser` varchar(250) DEFAULT NULL COMMENT 'Browser type from HTTP_USER_AGENT',
  `referer` varchar(500) DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) COMMENT 'Primary Key'
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `guest_2_word`
--

CREATE TABLE IF NOT EXISTS `guest_2_word` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key of table',
  `guest_id` int(11) NOT NULL COMMENT 'Foreign key to guest table',
  `word_id` int(11) NOT NULL COMMENT 'Foreign key to word table',
  PRIMARY KEY (`id`) COMMENT 'Primary key',
  KEY `guest_id` (`guest_id`),
  KEY `word_id` (`word_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=145 ;

-- --------------------------------------------------------

--
-- Table structure for table `word`
--

CREATE TABLE IF NOT EXISTS `word` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key of table',
  `name` varchar(30) NOT NULL COMMENT 'Descriptive word',
  PRIMARY KEY (`id`) COMMENT 'Primary key'
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=151 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
