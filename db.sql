-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Värd: 10.246.16.18:3306
-- Skapad: 02 jun 2013 kl 21:22
-- Serverversion: 5.1.66-0+squeeze1
-- PHP-version: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Tabellstruktur `_authors`
--

CREATE TABLE IF NOT EXISTS `_authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `password` varchar(120) NOT NULL,
  `email` varchar(90) NOT NULL,
  `new_email` varchar(90) NOT NULL,
  `email_verification` varchar(25) NOT NULL,
  `is_editor` tinyint(1) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `_category`
--

CREATE TABLE IF NOT EXISTS `_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `_editors_log`
--

CREATE TABLE IF NOT EXISTS `_editors_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editor` int(11) NOT NULL,
  `action` varchar(30) NOT NULL,
  `time` datetime NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `_news`
--

CREATE TABLE IF NOT EXISTS `_news` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `headline` varchar(80) NOT NULL,
  `intro` text NOT NULL,
  `body_text` mediumtext NOT NULL,
  `image` varchar(150) NOT NULL,
  `author` int(11) NOT NULL DEFAULT '0',
  `accepted_by` int(11) NOT NULL DEFAULT '0',
  `reported_by` int(11) NOT NULL DEFAULT '-1',
  `uploaded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `interesting` int(11) NOT NULL,
  `voted` text NOT NULL,
  `category` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `_sessions`
--

CREATE TABLE IF NOT EXISTS `_sessions` (
  `session_id` varchar(50) NOT NULL DEFAULT '',
  `session_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip_address` varchar(30) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `last_activity` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logged_in` tinyint(1) NOT NULL DEFAULT '0',
  `is_editor` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `_authors`
--

INSERT INTO `_authors` (`id`, `name`, `password`, `email`, `new_email`, `email_verification`, `is_editor`, `is_admin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '', '', 1, 1),
(0, 'Anonymous', '', '', '', '', 0, 0);

--
-- Dumpning av Data i tabell `_category`
--

INSERT INTO `_category` (`id`, `name`) VALUES
(1, 'General news'),
(2, 'Special scoop');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
