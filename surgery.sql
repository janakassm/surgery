-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 01, 2008 at 02:42 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `surgery`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_title` varchar(512) NOT NULL,
  `article_category` int(11) DEFAULT NULL,
  PRIMARY KEY (`article_id`),
  KEY `article_category` (`article_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_level` tinyint(1) NOT NULL DEFAULT '0',
  `category_title_sin` varchar(255) CHARACTER SET utf16 COLLATE utf16_sinhala_ci DEFAULT NULL,
  `category_title_eng` varchar(255) DEFAULT NULL,
  `category_link` varchar(1024) DEFAULT NULL,
  `category_parent_id` int(11) DEFAULT NULL,
  `category_assigned_menu` tinyint(2) DEFAULT NULL,
  `category_visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`category_id`),
  KEY `category_parent` (`category_parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_level`, `category_title_sin`, `category_title_eng`, `category_link`, `category_parent_id`, `category_assigned_menu`, `category_visible`) VALUES
(1, 0, 'ශරීරය', 'body', NULL, 0, NULL, 0),
(2, 0, 'අත', 'hand', NULL, 0, NULL, 0),
(3, 0, 'පාදය', 'Leg', NULL, 0, NULL, 0),
(4, 0, 'dsadads', '', NULL, 2, NULL, 0),
(5, 0, 'vvfvfdvfdv', '', NULL, 2, NULL, 0),
(6, 0, 'ccccc', '', NULL, 3, NULL, 0),
(7, 0, '43fdsfds', '', NULL, 1, NULL, 0),
(8, 0, 'vdbv', '', NULL, 4, NULL, 0),
(9, 0, 'xxxxxxx', '', NULL, 5, NULL, 0),
(10, 0, 'ශරීරය (body)', '', NULL, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('af86f326436281cc757c5016c31a6143', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:17.0) Gecko/20100101 Firefox/17.0', 1356154410, 'a:2:{s:9:"user_data";s:0:"";s:10:"tmpUploads";a:3:{s:2:"id";s:32:"af86f326436281cc757c5016c31a6143";s:10:"folderPath";s:66:"./temp_upload_data/topics/af86f326436281cc757c5016c31a6143/images/";s:5:"files";a:1:{s:32:"070924ca828c7c40bc39338ca0e8b1c0";a:4:{s:12:"realFileName";s:27:"Adjustable Valve Wrench.JPG";s:8:"fileName";s:36:"c0bdfe8b3ab833f00f1a6f0d24201d78.JPG";s:8:"filePath";s:102:"./temp_upload_data/topics/af86f326436281cc757c5016c31a6143/images/c0bdfe8b3ab833f00f1a6f0d24201d78.JPG";s:7:"fileUrl";s:100:"temp_upload_data/topics/af86f326436281cc757c5016c31a6143/images/c0bdfe8b3ab833f00f1a6f0d24201d78.JPG";}}}}'),
('fca8a66d1b56817428f5b8283ebe4818', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:17.0) Gecko/20100101 Firefox/17.0', 1355507647, 'a:1:{s:9:"user_data";s:0:"";}');

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_article` int(11) NOT NULL,
  `topic_heading` varchar(255) NOT NULL,
  `topic_content` text NOT NULL,
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
