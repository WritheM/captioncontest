-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- Host: memoria
-- Generation Time: Mar 20, 2013 at 10:49 AM
-- Server version: 5.1.63-0ubuntu0.11.10.1
-- PHP Version: 5.3.10-1ubuntu3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wmcc_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `caption`
--

CREATE TABLE IF NOT EXISTS `caption` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `qid` int(11) NOT NULL,
  `caption` text NOT NULL,
  `user` text NOT NULL,
  UNIQUE KEY `cid` (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8993 ;

-- --------------------------------------------------------

--
-- Table structure for table `contests`
--

CREATE TABLE IF NOT EXISTS `contests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `status` int(10) NOT NULL,
  `image_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=335 ;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `uri` varchar(2083) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=335 ;

-- --------------------------------------------------------

--
-- Table structure for table `image_tags`
--

CREATE TABLE IF NOT EXISTS `image_tags` (
  `image_id` int(11) NOT NULL,
  `tag` varchar(30) NOT NULL,
  PRIMARY KEY (`image_id`,`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setting` char(10) NOT NULL,
  `value` text NOT NULL,
  `user` text NOT NULL,
  UNIQUE KEY `setting` (`setting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `site`
--

CREATE TABLE IF NOT EXISTS `site` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setting` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(19000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updateddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `setting` (`setting`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=102 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(11) NOT NULL DEFAULT '1',
  `createddate` datetime NOT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rolechangedate` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `site`
--

INSERT INTO `site` (`ID`, `setting`, `value`, `updateddate`) VALUES
(1, 'code', 'wmcc', '2013-03-18 18:54:16'),
(2, 'title', 'My Caption Contest', '2013-03-18 18:54:28'),
(3, 'strapline', 'A great caption contest!', '2013-03-18 18:54:39'),
(4, 'metatitle', 'My Caption Contest', '2013-03-18 18:54:44'),
(5, 'metadescription', 'WMCC - a caption contest with community features', '2013-03-18 18:55:04'),
(6, 'metakeywords', 'community,captions,contest,free', '2013-03-18 18:55:18'),
(7, 'footer', 'Hosted by <a href="http://writhem.com/">WritheM Web Solutions</a>', '2012-12-11 01:56:43'),
(8, 'email', 'my@email.address', '2012-12-10 10:01:17'),
(15, 'style', 'default', '2012-12-11 01:57:33');

-- --------------------------------------------------------

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `email`, `password`, `role`, `createddate`, `lastlogin`, `notes`, `rolechangedate`) VALUES
(1, 'admin', 'admin@writhem.com', '21232f297a57a5a743894a0e4a801fc3', 3, '0000-00-00 00:00:00', NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
