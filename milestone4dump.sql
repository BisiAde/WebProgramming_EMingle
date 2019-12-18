-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2019 at 02:31 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE `cs518db` ;
USE `cs518db` ;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs518db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Channel`
--

CREATE TABLE `Channel` (
  `channel_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `purpose` varchar(140) NOT NULL,
  `type` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `creator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `channel`
--

INSERT INTO `Channel` (`channel_id`, `name`, `purpose`, `type`, `state`, `creator_id`) VALUES
(1, 'general', 'Generic messages', 'PUBLIC', 'ACTIVE', 1),
(2, 'random', 'Random messages', 'PUBLIC', 'ARCHIVE', 1),
(3, 'jokes', 'For fun jokes', 'PUBLIC', 'ARCHIVE', 1),
(4, 'secrets', 'For sharing secrets', 'PRIVATE', 'ACTIVE', 7),
(5, 'music', 'for sharing your favorite music', 'PUBLIC', 'ACTIVE', 1),
(6, '3', 'Sports', 'PUBLIC', 'ACTIVE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `channel_membership`
--

CREATE TABLE `Channel_Membership` (
  `channel_membership_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `channel_membership`
--

INSERT INTO `Channel_Membership` (`channel_membership_id`, `channel_id`, `user_id`) VALUES
(18, 1, 2),
(19, 1, 3),
(20, 1, 4),
(21, 1, 5),
(22, 1, 6),
(24, 1, 8),
(25, 2, 1),
(26, 2, 2),
(27, 2, 3),
(28, 2, 4),
(29, 2, 5),
(30, 2, 6),
(32, 2, 8),
(33, 3, 1),
(36, 4, 8),
(38, 5, 8),
(39, 1, 11),
(40, 2, 11),
(41, 3, 11),
(46, 1, 14),
(47, 2, 14),
(48, 1, 15),
(50, 1, 16),
(51, 2, 16),
(52, 1, 17),
(53, 2, 17),
(54, 1, 18),
(55, 2, 18),
(58, 3, 14),
(68, 1, 7),
(69, 2, 7),
(70, 3, 7),
(71, 3, 17),
(73, 2, 15),
(74, 3, 15),
(75, 4, 15),
(76, -1, 17),
(78, 1, 19),
(79, 1, 21),
(81, 6, 3),
(82, 1, 23),
(83, 2, 23),
(84, 1, 24),
(85, 2, 24),
(86, 1, 0),
(87, 2, 0),
(88, 1, 0),
(89, 2, 0),
(90, 1, 25),
(91, 2, 25),
(92, 1, 0),
(93, 2, 0),
(94, 1, 0),
(95, 2, 0),
(96, 1, 26),
(97, 2, 26),
(98, 1, 27),
(99, 2, 27),
(100, 4, 27),
(101, 1, 28),
(102, 2, 28),
(103, 1, 1),
(104, 5, 20),
(105, -1, 20),
(106, 1, 20),
(107, 1, 0),
(108, 2, 0),
(109, -1, 1),
(110, 1, 29),
(111, 2, 29),
(112, -1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `Post` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `pair_user_id` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `Post` (`post_id`, `user_id`, `fname`, `lname`, `channel_id`, `parent_id`, `pair_user_id`, `datetime`, `content`) VALUES
(388, 1, 'Tow', 'Mater', 1, 380, '', '2018-11-12 21:01:02', 'g'),
(389, 1, 'Tow', 'Mater', -1, -1, '1.8', '2018-11-13 00:25:46', 'jeeeee'),
(390, 1, 'Tow', 'Mater', -1, -1, '1.8', '2018-11-13 00:26:27', 'ogass'),
(391, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-13 00:27:28', 'its been a learning experience'),
(392, 1, 'Tow', 'Mater', -1, -1, '1.3', '2018-11-13 03:34:39', 'learning curve it is'),
(393, 1, 'Tow', 'Mater', -1, -1, '1.3', '2018-11-13 03:35:53', 'this is my message'),
(394, 19, 'Bisi', 'bisi', 1, 391, '', '2018-11-13 08:54:10', 'really'),
(395, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-13 14:40:02', 'posing messages for 1'),
(396, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-13 14:40:09', 'posing messages for 2'),
(397, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-13 14:40:15', 'posing messages for 3'),
(398, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-13 14:40:21', 'posing messages for 4'),
(399, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-13 14:40:28', 'posing messages for  5'),
(400, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-13 14:40:43', 'posing messages for 1 to the letter'),
(401, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-13 14:40:55', 'posing messages 2 to the lette'),
(402, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-13 14:41:41', 'messenger app not working'),
(403, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-13 14:42:01', 'The design need some more work tot be done'),
(404, 21, 'ironman', 'ironman', 1, -1, '', '2018-11-13 14:45:20', 'the  return of the avengers'),
(405, 21, 'ironman', 'ironman', 1, -1, '', '2018-11-13 14:45:39', 'Incredible hulk is such a lazy character'),
(406, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-13 15:52:48', 'Entering  post'),
(407, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-13 23:22:49', 'using j'),
(408, 3, 'Doc', 'Hudson', 6, -1, '', '2018-11-15 19:15:51', 'Group Number 3 ?'),
(409, 1, 'Tow', 'Mater', 6, 408, '', '2018-11-15 19:16:48', 'Yes @ group number 3 Tow Mater was here'),
(410, 3, 'Doc', 'Hudson', 1, -1, '', '2018-11-15 22:56:29', 'post in my bock'),
(411, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-20 18:16:17', '1'),
(412, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-20 18:16:20', '2'),
(413, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-20 18:16:25', '3'),
(414, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-20 18:16:30', '4'),
(415, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-20 18:16:34', '5'),
(416, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-20 18:16:39', '6'),
(421, 1, 'Tow', 'Mater', 1, 420, '', '2018-11-20 18:17:25', '10'),
(422, 1, 'Tow', 'Mater', 1, 421, '', '2018-11-20 18:17:33', '9'),
(423, 1, 'Tow', 'Mater', 1, 421, '', '2018-11-20 18:17:40', '8'),
(424, 1, 'Tow', 'Mater', 1, 421, '', '2018-11-20 18:17:43', '8'),
(425, 1, 'Tow', 'Mater', 1, 421, '', '2018-11-20 18:17:45', '8'),
(426, 1, 'Tow', 'Mater', 1, 421, '', '2018-11-20 18:17:48', '8'),
(427, 1, 'Tow', 'Mater', 1, 421, '', '2018-11-20 18:17:50', '8'),
(428, 1, 'Tow', 'Mater', 1, 421, '', '2018-11-20 18:17:52', '8'),
(429, 1, 'Tow', 'Mater', 1, 421, '', '2018-11-20 18:17:57', '8'),
(430, 1, 'Tow', 'Mater', 1, 421, '', '2018-11-20 18:17:59', '8'),
(431, 1, 'Tow', 'Mater', 1, 421, '', '2018-11-20 18:18:01', '8'),
(432, 1, 'Tow', 'Mater', 1, -1, '', '2018-11-20 18:22:05', 'fggdfgdfg'),
(433, 20, 'hulk', 'hulk', 5, -1, '', '2018-11-28 00:52:22', 'i love jazz'),
(434, 20, 'hulk', 'hulk', -1, -1, '1.20', '2018-11-28 00:53:20', 'hey Tow mater, mate.. whatever!!!'),
(435, 20, 'hulk', 'hulk', 1, -1, '', '2018-12-09 20:42:11', 'I am hulk posting'),
(436, 1, 'Tow', 'Mater', -1, -1, '1.2', '2018-12-11 15:34:04', 'her to chat with you'),
(437, 1, 'Tow', 'Mater', 1, -1, '', '2018-12-21 15:39:34', 'my wat'),
(438, 1, 'Tow', 'Mater', 1, -1, '', '2019-01-08 00:09:44', 'Happy new year'),
(439, 1, 'Tow', 'Mater', 1, -1, '', '2019-01-08 00:10:05', 'its started out okay'),
(440, 1, 'Tow', 'Mater', -1, -1, '1.2', '2019-01-08 00:10:42', 'Are you taking any certifications this year?'),
(441, 1, 'Tow', 'Mater', 1, -1, '', '2019-01-08 00:40:50', 'Posting in 2019'),
(442, 21, 'ironman', 'ironman', 1, -1, '', '2019-01-08 01:23:23', 'it 2019 ironman world'),
(443, 21, 'ironman', 'ironman', 1, -1, '', '2019-01-08 01:23:41', '23'),
(444, 21, 'ironman', 'ironman', 1, -1, '', '2019-01-08 01:23:41', '23'),
(445, 21, 'ironman', 'ironman', 1, -1, '', '2019-01-08 01:23:49', 'certifications'),
(446, 21, 'ironman', 'ironman', 1, -1, '', '2019-01-08 01:23:55', 'goals this year'),
(447, 4, 'Finn', 'McMissile', 1, -1, '', '2019-01-08 01:31:35', 'I know I probably should have been posting before'),
(448, 4, 'Finn', 'McMissile', 1, -1, '', '2019-01-08 01:32:27', '3'),
(449, 4, 'Finn', 'McMissile', 1, -1, '', '2019-01-08 01:32:32', '4'),
(450, 4, 'Finn', 'McMissile', 1, -1, '', '2019-01-08 01:32:36', '78'),
(451, 4, 'Finn', 'McMissile', 1, -1, '', '2019-01-08 01:32:41', '2019'),
(452, 4, 'Finn', 'McMissile', 1, -1, '', '2019-01-08 01:32:46', '45'),
(453, 4, 'Finn', 'McMissile', 1, -1, '', '2019-01-08 01:32:50', '3643'),
(454, 4, 'Finn', 'McMissile', 1, -1, '', '2019-01-08 01:33:29', '45'),
(455, 4, 'Finn', 'McMissile', 1, -1, '', '2019-01-08 01:33:32', '45'),
(456, 4, 'Finn', 'McMissile', 1, -1, '', '2019-01-08 01:33:38', '78'),
(457, 4, 'Finn', 'McMissile', 1, -1, '', '2019-01-08 01:33:42', '12313'),
(458, 4, 'Finn', 'McMissile', 1, -1, '', '2019-01-08 01:33:47', '67'),
(459, 4, 'Finn', 'McMissile', -1, -1, '2.4', '2019-01-08 10:21:25', 'happy new year'),
(460, 4, 'Finn', 'McMissile', -1, -1, '4.21', '2019-01-08 22:27:39', 'take it'),
(461, 4, 'Finn', 'McMissile', -1, -1, '4.21', '2019-01-08 22:27:45', '89'),
(462, 4, 'Finn', 'McMissile', -1, -1, '4.21', '2019-01-08 22:27:51', '90'),
(463, 5, 'Lightning', 'McQueen', 1, -1, '', '2019-01-11 08:08:06', 'my very first post I think'),
(464, 5, 'Lightning', 'McQueen', 1, -1, '', '2019-01-11 08:08:43', 'this year started out fully loaded'),
(465, 5, 'Lightning', 'McQueen', 1, -1, '', '2019-01-11 16:06:55', 'cat');

-- --------------------------------------------------------

--
-- Table structure for table `reaction`
--

CREATE TABLE `Reaction` (
  `reaction_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `reaction_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reaction`
--

INSERT INTO `Reaction` (`reaction_id`, `post_id`, `user_id`, `fname`, `lname`, `reaction_type_id`) VALUES
(25, 11, 3, 'Doc', 'Hudson', 1),
(29, 70, 3, 'Doc', 'Hudson', 1),
(30, 11, 2, 'Sally', 'Carrera', 1),
(33, 88, 2, 'Sally', 'Carrera', 1),
(34, 77, 2, 'Sally', 'Carrera', 1),
(37, 45, 1, 'Tow', 'Mater', 2),
(119, 93, 1, 'Tow', 'Mater', 0),
(177, 92, 1, 'Tow', 'Mater', 1),
(178, 11, 1, 'Tow', 'Mater', 2),
(180, 103, 17, 'ADMINISTRATOR', '', 2),
(184, 40, 17, 'ADMINISTRATOR', '', 1),
(187, 131, 17, 'ADMINISTRATOR', '', 2),
(192, 152, 17, 'ADMINISTRATOR', '', 1),
(193, 135, 17, 'ADMINISTRATOR', '', 2),
(196, 235, 17, 'ADMINISTRATOR', '', 1),
(197, 380, 17, 'ADMINISTRATOR', '', 2),
(198, 380, 1, 'Tow', 'Mater', 2),
(199, 381, 1, 'Tow', 'Mater', 1),
(200, 391, 1, 'Tow', 'Mater', 1),
(201, 395, 1, 'Tow', 'Mater', 1),
(202, 406, 1, 'Tow', 'Mater', 2),
(203, 408, 1, 'Tow', 'Mater', 1),
(204, 410, 21, 'ironman', 'ironman', 1),
(205, 435, 1, 'Tow', 'Mater', 2),
(206, 458, 4, 'Finn', 'McMissile', 1),
(207, 457, 4, 'Finn', 'McMissile', 1),
(208, 459, 4, 'Finn', 'McMissile', 1),
(209, 456, 4, 'Finn', 'McMissile', 2),
(210, 455, 4, 'Finn', 'McMissile', 1),
(211, 453, 4, 'Finn', 'McMissile', 1),
(212, 462, 4, 'Finn', 'McMissile', 1),
(213, 454, 4, 'Finn', 'McMissile', 1),
(214, 463, 5, 'Lightning', 'McQueen', 1),
(215, 464, 5, 'Lightning', 'McQueen', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reaction_type`
--

CREATE TABLE `Reaction_Type` (
  `reaction_type_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `emoji` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reaction_type`
--

INSERT INTO `Reaction_Type` (`reaction_type_id`, `name`, `emoji`) VALUES
(1, 'thumbs_up', '&#128077;'),
(2, 'thumbs_down', '&#128078;');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `Role` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `Role` (`role_id`, `user_id`, `role_type`) VALUES
(2, 16, 'DEFAULT'),
(3, 1, 'DEFAULT'),
(4, 2, 'DEFAULT'),
(5, 3, 'DEFAULT'),
(6, 4, 'DEFAULT'),
(7, 5, 'DEFAULT'),
(8, 6, 'DEFAULT'),
(9, 7, 'DEFAULT'),
(10, 8, 'DEFAULT'),
(11, 11, 'DEFAULT'),
(12, 14, 'DEFAULT'),
(13, 15, 'DEFAULT'),
(14, 16, 'DEFAULT'),
(15, 17, 'ADMIN'),
(16, 18, 'DEFAULT'),
(17, 23, 'DEFAULT'),
(18, 24, 'DEFAULT'),
(19, 0, 'DEFAULT'),
(20, 0, 'DEFAULT'),
(21, 25, 'DEFAULT'),
(22, 0, 'DEFAULT'),
(23, 0, 'DEFAULT'),
(24, 26, 'DEFAULT'),
(25, 27, 'DEFAULT'),
(26, 28, 'DEFAULT'),
(27, 0, 'DEFAULT'),
(28, 29, 'DEFAULT');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `Settings` (
  `settings_id` int(11) NOT NULL,
  `challenge_expr` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `two_factor_active` tinyint(1) NOT NULL,
  `two_factor_challenge` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `Settings` (`settings_id`, `challenge_expr`, `user_id`, `two_factor_active`, `two_factor_challenge`) VALUES
(12, '2018-11-20 16:58:47', 17, 0, '7AaE');

-- --------------------------------------------------------

--
-- Table structure for table `tokentbl`
--

CREATE TABLE `tokentbl` (
  `user_id` int(11) NOT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tokentbl`
--

INSERT INTO `tokentbl` (`user_id`, `token`) VALUES
(1, 'pg6zs3rv4n'),
(2, 'jbw6kn952u'),
(3, ''),
(4, ''),
(5, ''),
(6, ''),
(19, ''),
(17, ''),
(21, ''),
(20, ''),
(25, '40'),
(27, ''),
(30, 'c5q9ydjs4l')
(31, '');

-- --------------------------------------------------------

--
-- Table structure for table `twofactor`
--

CREATE TABLE `twofactor` (
  `USER` varchar(20) NOT NULL,
  `PASSWORD` varchar(10) NOT NULL,
  `GOOGLEAUTH` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `twofactor`
--

INSERT INTO `twofactor` (`USER`, `PASSWORD`, `GOOGLEAUTH`) VALUES
('bisi', 'good', 'ghgjgj1233'),
('Doc Hudson', '@doc', 'XIZ73RXRRZFY5ODG'),
('Doc Hudson', '12345', 'PMXM3JQIR7DYQNCO'),
('Tow Mater', '12345', 'A3KR4LZFOTNFI5JX'),
('Tow Mater', '12345', 'EOI3IDI4HP7M4DFO'),
('bisi', '12345', 'MVGX3ILTB7V3AFAB'),
('koko', '12345', 'NVYH5GJK2P75NXJS');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `User` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `code` int(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `twitoken` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `User` (`user_id`, `fname`, `lname`, `email`, `password`, `code`, `token`,`twitoken`) VALUES
(1, 'Tow', 'Mater', 'mater@rsprings.gov', '@mater', 168693, '',''),
(2, 'Sally', 'Carrera', 'porsche@rsprings.gov', '@sally', 0, '',''),
(3, 'Doc', 'Hudson', 'hornet@rsprings.gov', '@doc', 0, '',''),
(4, 'Finn', 'McMissile', 'topsecret@agent.org', '@mcmissile', 0, '',''),
(5, 'Lightning', 'McQueen', 'kachow@rusteze.com', '@mcqueen', 0, '',''),
(6, 'Chick', 'Hicks', 'chinga@cars.com', '@chick', 0, '',''),
(17, 'ADMINISTRATOR', '', 'admin@super.com', '@admin', 0, '',''),
(19, 'Bisi', 'bisi', 'bisi@gmail.com', '@bisi', 0, '',''),
(20, 'hulk', 'hulk', 'hulk@gmail.com', '@hulk', 200, '',''),
(21, 'ironman', 'ironman', 'ironman@gmail.com', '@ironman', 0,'',''),
(22, 'wonderwoman', 'wonderwoman', 'wonderwoman@gmail.com', 'wonderwomanhulk', 0, '',''),
(23, 'xman', 'steelfingers', 'xman@gmail.com', '@xman', 0, '',''),
(24, 'richard', 'swain', 'richardswain@gmail.com', '@richard', 0, '',''),
(25, 'iamyankoli', 'lolu', 'yanko@gmail.com', 'yanko', 0, '',''),
(26, 'bankole', 'eniola', 'enny@gmaail.com', '@eniola', 0, '',''),
(27, 'abel', 'software', 'aweld002@odu.edu', '@abel', 0, '',''),
(28, 'mark', '518', 'mark518@gmail.com', '1234', 0, '',''),
(29, 'Adebisi', 'Adeniran', 'bisiade@gmail.com', '@adebisi', 0, '',''),
(30, 'Bisi', 'Adeniran', 'folufola@gmail.com', 'webprogrammer', 0, '',''),
(31, 'very', 'very', 'aaden003@odu.edu', '@very', 0, '',''),
(32, 'jeje', 'jeje', 'jeje@gmail.com', '@jeje', 189140, '',''),
(33, 'mymy', 'mymy', 'mymy@gmail.com', '@my', 0, '',''),
(34, 'toto', 'toto', 'toto@gmail.com', '@toto', 0, '',''),
(35, 'koko', 'koko', 'koko@gmail.com', '@koko', 0, '',''),
(36, 'mylordy', '', 'mylordy@gmail.com', '', 0, '55hkhlhkjhh88797909ASDFSF',''),
(40, 'bisi', '', 'femlajoe28@gmail.com', '112467130867158337542', 0, '112467130867158337542','');



--
-- Indexes for dumped tables
--

--
-- Indexes for table `channel`
--
ALTER TABLE `Channel`
  ADD PRIMARY KEY (`channel_id`);

--
-- Indexes for table `channel_membership`
--
ALTER TABLE `Channel_Membership`
  ADD PRIMARY KEY (`channel_membership_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `Post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `reaction`
--
ALTER TABLE `Reaction`
  ADD PRIMARY KEY (`reaction_id`);

--
-- Indexes for table `reaction_type`
--
ALTER TABLE `Reaction_Type`
  ADD PRIMARY KEY (`reaction_type_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `Role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `Settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `tokentbl`
--
ALTER TABLE `tokentbl`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `channel`
--
ALTER TABLE `Channel`
  MODIFY `channel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `channel_membership`
--
ALTER TABLE `Channel_Membership`
  MODIFY `channel_membership_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `Post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=466;

--
-- AUTO_INCREMENT for table `reaction`
--
ALTER TABLE `Reaction`
  MODIFY `reaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT for table `reaction_type`
--
ALTER TABLE `Reaction_Type`
  MODIFY `reaction_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `Role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `Settings`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `User`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
