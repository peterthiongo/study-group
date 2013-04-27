-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 27, 2013 at 01:27 PM
-- Server version: 5.1.50
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `study`
--
CREATE DATABASE `study` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `study`;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `questions` varchar(7000) NOT NULL,
  `answers` varchar(8000) NOT NULL,
  `name` varchar(500) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `public` tinyint(1) NOT NULL,
  `originator` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tests`
--

