-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 25, 2016 at 03:52 AM
-- Server version: 5.7.14
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `readerself`
--

--
-- Dumping data for table `action`
--

INSERT INTO `action` VALUES(1, 'read', '2016-09-09 20:46:23');
INSERT INTO `action` VALUES(2, 'star', '2016-09-09 20:46:23');
INSERT INTO `action` VALUES(3, 'subscribe', '2016-09-09 20:46:23');
INSERT INTO `action` VALUES(4, 'read_all', '2016-09-09 20:46:23');
INSERT INTO `action` VALUES(5, 'exclude', '2016-09-09 20:46:23');
INSERT INTO `action` VALUES(7, 'email', '2016-09-09 20:46:23');
INSERT INTO `action` VALUES(11, 'elasticsearch', '2016-09-09 20:46:23');

--
-- Dumping data for table `member`
--

INSERT INTO `member` VALUES(1, 'example@example.com', '$2y$13$A7u4u3TkyKB8AY0o.KJs4.P495uSbI74ECIjuboy7h5mf8OZwetCu', 1, '2016-09-09 20:46:23', '2016-09-09 20:46:23');
