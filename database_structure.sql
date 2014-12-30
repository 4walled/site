-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 28, 2014 at 05:27 PM
-- Server version: 5.5.31-1~dotdeb.0
-- PHP Version: 5.3.27-1~dotdeb.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `4walled`
--

-- --------------------------------------------------------

--
-- Table structure for table `Image`
--
-- Creation: Jan 20, 2013 at 10:20 AM
-- Last update: Dec 28, 2014 at 04:27 PM
-- Last check: Dec 27, 2014 at 11:14 PM
--

DROP TABLE IF EXISTS `Image`;
CREATE TABLE IF NOT EXISTS `Image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `poster_id` int(10) unsigned NOT NULL,
  `source_id` int(10) unsigned NOT NULL,
  `md5` binary(32) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `width` smallint(5) unsigned NOT NULL,
  `height` smallint(5) unsigned NOT NULL,
  `aspect_ratio` smallint(5) unsigned NOT NULL,
  `downloads` int(10) unsigned NOT NULL,
  `date_added` datetime NOT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `MD5` (`md5`),
  KEY `id_poster_id` (`poster_id`),
  KEY `id_source_id` (`source_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1555336 ;

-- --------------------------------------------------------

--
-- Table structure for table `Poster`
--
-- Creation: Jan 20, 2013 at 10:20 AM
-- Last update: Dec 28, 2014 at 01:00 PM
-- Last check: Dec 27, 2014 at 11:14 PM
--

DROP TABLE IF EXISTS `Poster`;
CREATE TABLE IF NOT EXISTS `Poster` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tripcode` varchar(75) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `poster_key` (`name`,`tripcode`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29334 ;

-- --------------------------------------------------------

--
-- Table structure for table `Reports`
--
-- Creation: Jan 20, 2013 at 10:20 AM
-- Last update: Aug 09, 2013 at 06:25 PM
-- Last check: Aug 09, 2013 at 06:25 PM
--

DROP TABLE IF EXISTS `Reports`;
CREATE TABLE IF NOT EXISTS `Reports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` int(10) unsigned NOT NULL,
  `ip_address` int(10) unsigned NOT NULL,
  `md5` binary(32) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `image_address` (`image_id`,`ip_address`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `scraped`
--
-- Creation: Jan 20, 2013 at 10:20 AM
-- Last update: Dec 28, 2014 at 04:00 PM
-- Last check: Dec 27, 2014 at 11:14 PM
--

DROP TABLE IF EXISTS `scraped`;
CREATE TABLE IF NOT EXISTS `scraped` (
  `image_id` bigint(20) NOT NULL,
  `source_id` int(11) NOT NULL,
  PRIMARY KEY (`image_id`,`source_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Source`
--
-- Creation: Jan 20, 2013 at 10:20 AM
-- Last update: Jan 20, 2013 at 10:20 AM
-- Last check: Aug 09, 2013 at 06:25 PM
--

DROP TABLE IF EXISTS `Source`;
CREATE TABLE IF NOT EXISTS `Source` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_key` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `Tag`
--
-- Creation: Jan 20, 2013 at 10:20 AM
-- Last update: Dec 28, 2014 at 11:23 AM
-- Last check: Dec 27, 2014 at 11:14 PM
--

DROP TABLE IF EXISTS `Tag`;
CREATE TABLE IF NOT EXISTS `Tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_key` (`name`),
  KEY `name_id` (`name`,`id`),
  FULLTEXT KEY `tag_name_fulltext` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1118109 ;

-- --------------------------------------------------------

--
-- Table structure for table `Tag_Image`
--
-- Creation: Jan 20, 2013 at 10:20 AM
-- Last update: Dec 28, 2014 at 02:28 PM
-- Last check: Dec 27, 2014 at 11:14 PM
--

DROP TABLE IF EXISTS `Tag_Image`;
CREATE TABLE IF NOT EXISTS `Tag_Image` (
  `image_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`image_id`,`tag_id`),
  KEY `id_tag_id` (`tag_id`),
  KEY `tag_to_image` (`tag_id`,`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
