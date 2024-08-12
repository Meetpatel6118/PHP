-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 06, 2024 at 08:58 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `childrengamedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `game_history`
--

DROP TABLE IF EXISTS `game_history`;
CREATE TABLE IF NOT EXISTS `game_history` (
  `game_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `game_session_id` int DEFAULT NULL,
  `level` int DEFAULT NULL,
  `result` varchar(50) DEFAULT NULL,
  `lives_used` int DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`game_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `game_sessions`
--

DROP TABLE IF EXISTS `game_sessions`;
CREATE TABLE IF NOT EXISTS `game_sessions` (
  `session_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `current_level` int DEFAULT '1',
  `lives_remaining` int DEFAULT '6',
  PRIMARY KEY (`session_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions_answers`
--

DROP TABLE IF EXISTS `questions_answers`;
CREATE TABLE IF NOT EXISTS `questions_answers` (
  `question_id` int NOT NULL AUTO_INCREMENT,
  `level` int DEFAULT NULL,
  `question_text` text,
  `correct_answer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--