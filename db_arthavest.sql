-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 22, 2016 at 12:02 AM
-- Server version: 5.1.33
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_arthavest`
--

-- --------------------------------------------------------

--
-- Table structure for table `adm_login`
--

CREATE TABLE IF NOT EXISTS `adm_login` (
  `id_login` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(99) NOT NULL,
  `password` varchar(99) NOT NULL,
  `last_login` datetime NOT NULL,
  PRIMARY KEY (`id_login`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `adm_login`
--

INSERT INTO `adm_login` (`id_login`, `username`, `password`, `last_login`) VALUES
(1, 'aiman', 'fadhil', '0000-00-00 00:00:00'),
(3, 'admin', 'admin', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `t_body`
--

CREATE TABLE IF NOT EXISTS `t_body` (
  `id_tbody` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `isi_menu` text NOT NULL,
  PRIMARY KEY (`id_tbody`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `t_body`
--

INSERT INTO `t_body` (`id_tbody`, `id_menu`, `isi_menu`) VALUES
(1, 17, '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n'),
(2, 30, '<p>INI ISI PARENT 2 CHILD 1</p>\r\n'),
(3, 28, '<p>INI ISI PARENT 2</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `t_head`
--

CREATE TABLE IF NOT EXISTS `t_head` (
  `id_thead` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `head_title` varchar(99) NOT NULL,
  PRIMARY KEY (`id_thead`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `t_head`
--


-- --------------------------------------------------------

--
-- Table structure for table `t_head_img`
--

CREATE TABLE IF NOT EXISTS `t_head_img` (
  `id_img` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `image_name` varchar(99) NOT NULL,
  PRIMARY KEY (`id_img`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `t_head_img`
--

INSERT INTO `t_head_img` (`id_img`, `id_menu`, `image_name`) VALUES
(42, 28, '2015-10-19_00001.jpg'),
(38, 1, 'aa.png'),
(39, 1, 'asiimov.png'),
(40, 1, 'badge.png'),
(41, 30, 'DreamhackSignature-1.png'),
(37, 17, 'DreamhackSignature-1.png');

-- --------------------------------------------------------

--
-- Table structure for table `t_language`
--

CREATE TABLE IF NOT EXISTS `t_language` (
  `id_language` int(11) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(99) NOT NULL,
  PRIMARY KEY (`id_language`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `t_language`
--

INSERT INTO `t_language` (`id_language`, `language_name`) VALUES
(1, 'Indonesia'),
(2, 'English');

-- --------------------------------------------------------

--
-- Table structure for table `t_menu`
--

CREATE TABLE IF NOT EXISTS `t_menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) NOT NULL,
  `id_child` int(11) NOT NULL,
  `menu_name` varchar(99) NOT NULL,
  `child_active` int(11) NOT NULL,
  `lvl_menu` int(11) NOT NULL,
  `id_language` int(11) NOT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `t_menu`
--

INSERT INTO `t_menu` (`id_menu`, `id_parent`, `id_child`, `menu_name`, `child_active`, `lvl_menu`, `id_language`) VALUES
(1, 1, 0, 'Home', 0, 1, 1),
(32, 5, 0, 'Parent 3', 0, 1, 1),
(31, 4, 1, 'Contact Us', 0, 1, 1),
(17, 2, 0, 'Parent 1', 0, 1, 1),
(28, 3, 0, 'Parent 2', 0, 1, 1),
(30, 3, 0, 'p2c1', 0, 2, 1),
(33, 6, 0, 'Parent 4', 0, 1, 1),
(35, 7, 0, 'PARENT 5', 0, 1, 1);
