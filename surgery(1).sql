-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 08, 2013 at 01:31 AM
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
-- Table structure for table `advertisement`
--

CREATE TABLE IF NOT EXISTS `advertisement` (
  `advertisement_id` int(11) NOT NULL AUTO_INCREMENT,
  `advertisement_title` varchar(255) NOT NULL,
  `advertisement_body` text NOT NULL,
  `advertisement_brief` text NOT NULL,
  `advertisement_start_date` date NOT NULL,
  `advertisement_expire_date` date DEFAULT NULL,
  `advertisement_is_expiring` tinyint(1) NOT NULL,
  `advertisement_is_saved` tinyint(1) NOT NULL DEFAULT '0',
  `advertisement_is_public` tinyint(1) NOT NULL,
  PRIMARY KEY (`advertisement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `advertisement`
--

INSERT INTO `advertisement` (`advertisement_id`, `advertisement_title`, `advertisement_body`, `advertisement_brief`, `advertisement_start_date`, `advertisement_expire_date`, `advertisement_is_expiring`, `advertisement_is_saved`, `advertisement_is_public`) VALUES
(1, '', '', '', '0000-00-00', NULL, 0, 1, 0),
(2, 'dfsads', '<p>sdsadasdsadasd</p>', 'dsadsad', '2013-01-06', '2013-01-15', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `advertisement_image`
--

CREATE TABLE IF NOT EXISTS `advertisement_image` (
  `advertisement_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `advertisement_id` int(11) NOT NULL,
  `advertisement_image_url` varchar(1024) NOT NULL,
  `advertisement_image_thumb_url` varchar(1024) NOT NULL,
  `advertisement_image_index` varchar(512) NOT NULL,
  `advertisement_image_sort_count` int(11) NOT NULL,
  PRIMARY KEY (`advertisement_image_id`),
  KEY `topic_id` (`advertisement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `advertisement_image`
--

INSERT INTO `advertisement_image` (`advertisement_image_id`, `advertisement_id`, `advertisement_image_url`, `advertisement_image_thumb_url`, `advertisement_image_index`, `advertisement_image_sort_count`) VALUES
(2, 1, 'user_data/advertisements/1/images/bcb3798d312ed46335afe6b1c0ebd398.jpg', 'user_data/advertisements/1/images/thumb/bcb3798d312ed46335afe6b1c0ebd398.jpg', 'b38517ebd5680867bc60bbea83f49286', 0),
(3, 1, 'user_data/advertisements/1/images/5aeb1f62f6cd496dc81c07d58b82f143.jpg', 'user_data/advertisements/1/images/thumb/5aeb1f62f6cd496dc81c07d58b82f143.jpg', '41a484992da40c0434877380ad9e6090', 0),
(4, 1, 'user_data/advertisements/1/images/5aeb1f62f6cd496dc81c07d58b82f14337.jpg', 'user_data/advertisements/1/images/thumb/5aeb1f62f6cd496dc81c07d58b82f14337.jpg', '1636e7ac9234f4d2feace1df6ddb6402', 0),
(5, 1, 'user_data/advertisements/1/images/5aeb1f62f6cd496dc81c07d58b82f14390.jpg', 'user_data/advertisements/1/images/thumb/5aeb1f62f6cd496dc81c07d58b82f14390.jpg', '060bd8f28945be48c641970d57647486', 0),
(6, 2, 'user_data/advertisements/2/images/c4cf192ff255dddf4cc2018dc622f834.jpg', 'user_data/advertisements/2/images/thumb/c4cf192ff255dddf4cc2018dc622f834.jpg', '319eb563e46732d3bdb1a1ee7180dedf', 0);

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_title` varchar(512) NOT NULL,
  `article_category` int(11) DEFAULT NULL,
  `article_sort_count` int(11) NOT NULL,
  `article_is_public` tinyint(1) NOT NULL DEFAULT '0',
  `article_is_saved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_id`),
  KEY `article_category` (`article_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`article_id`, `article_title`, `article_category`, `article_sort_count`, `article_is_public`, `article_is_saved`) VALUES
(1, '', NULL, -1, 0, 0),
(2, '', NULL, -2, 0, 0),
(3, '', NULL, -3, 0, 0);

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
('1cb46793f8c345d60e66247d34fab0c6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:17.0) Gecko/20100101 Firefox/17.0', 1356864468, 'a:2:{s:9:"user_data";s:0:"";s:30:"admin_current_advertisement_id";s:1:"1";}'),
('2d55e446cf0af26612593603b21f0d9c', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:17.0) Gecko/20100101 Firefox/17.0', 1357474364, 'a:3:{s:9:"user_data";s:0:"";s:24:"admin_current_article_id";i:3;s:30:"admin_current_advertisement_id";s:1:"2";}');

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_article` int(11) NOT NULL,
  `topic_heading` varchar(255) NOT NULL,
  `topic_content` text NOT NULL,
  `topic_sort_count` int(11) NOT NULL DEFAULT '0',
  `topic_is_public` tinyint(1) NOT NULL DEFAULT '1',
  `topic_is_saved` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`topic_id`, `topic_article`, `topic_heading`, `topic_content`, `topic_sort_count`, `topic_is_public`, `topic_is_saved`) VALUES
(1, 2, '', '', -1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `topic_image`
--

CREATE TABLE IF NOT EXISTS `topic_image` (
  `topic_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `topic_image_url` varchar(1024) NOT NULL,
  `topic_image_thumb_url` varchar(1024) NOT NULL,
  `topic_image_index` varchar(512) NOT NULL,
  `topic_image_sort_count` int(11) NOT NULL,
  PRIMARY KEY (`topic_image_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
