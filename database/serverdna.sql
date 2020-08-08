-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2020 at 05:17 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `serverdna`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `ev_id` int(11) NOT NULL,
  `ev_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ev_description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ev_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `game_id` int(11) DEFAULT NULL,
  `reg_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `reg_max_count` int(3) NOT NULL,
  `reg_cur_count` int(3) DEFAULT 0,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `venue` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `organisers` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `applied_by` int(11) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `approved_at` datetime NOT NULL,
  `app_id` int(11) DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_application`
--

CREATE TABLE `event_application` (
  `app_id` int(11) NOT NULL,
  `app_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `app_description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `game_id` int(11) DEFAULT NULL,
  `team_count` int(3) DEFAULT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `venue` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `organiser` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `contact_method` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_no` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status_upd_at` datetime DEFAULT NULL,
  `status_upd_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `event_application`
--

INSERT INTO `event_application` (`app_id`, `app_name`, `app_description`, `game_id`, `team_count`, `start_datetime`, `end_datetime`, `venue`, `city`, `state`, `organiser`, `created_by`, `created_at`, `contact_method`, `contact_no`, `contact_email`, `status`, `status_upd_at`, `status_upd_by`, `deleted_at`) VALUES
(1, 'Some Dota 2 Tournament with a randomly long name', 'Some Dota 2 Tournament with a randomly long name', 1, 16, '2020-06-11 00:00:00', '2020-06-13 00:00:00', 'Taylor\'s University', 'Petaling Jaya', 'Selangor', 'ONE Esports', 2, '2020-06-06 00:00:00', 'Email', '0186632500', 'oneesports@gmail.com', 'pending', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `game_id` int(11) NOT NULL,
  `game_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `platforms` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `genres` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`game_id`, `game_name`, `platforms`, `genres`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Dota 2', 'PC', 'MOBA,STRATEGY', 1, '2020-07-10 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('teamInvite','teamBroadcast','sudoBroadcast','adminBroadcast','eventAlert') COLLATE utf8_unicode_ci NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `read_at` datetime DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `title`, `description`, `type`, `from_user_id`, `to_user_id`, `created_at`, `read_at`, `delete_at`) VALUES
(8, 'Pending team invitation.', 'You are invited to team, Notification Test as a captain. Do accept my invitation !', 'teamInvite', 58, 3, '2020-08-08 23:15:19', NULL, NULL),
(9, 'Pending team invitation.', 'You are invited to team, Notification Test as a vice. Do accept my invitation !', 'teamInvite', 58, 5, '2020-08-08 23:15:19', NULL, NULL),
(10, 'Pending team invitation.', 'You are invited to team, Notification Test as a player. Do accept my invitation !', 'teamInvite', 58, 63, '2020-08-08 23:15:19', NULL, NULL),
(11, 'Pending team invitation.', 'You are invited to team, Notification Test as a substitute. Do accept my invitation !', 'teamInvite', 58, 4, '2020-08-08 23:15:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `team_id` int(11) NOT NULL,
  `team_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `games` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` enum('pending','authenticated','') COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `delete_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`team_id`, `team_name`, `games`, `created_at`, `created_by`, `status`, `updated_at`, `delete_at`) VALUES
(1, '123', '1', '2020-07-21 21:04:37', 58, 'pending', NULL, NULL),
(12, 'Notification Test', '1', '2020-08-08 23:15:19', 58, 'pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `DoB` date NOT NULL,
  `gender` enum('male','female') COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('created','authenticated','inactive','') COLLATE utf8_unicode_ci NOT NULL,
  `accessed_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` int(1) NOT NULL DEFAULT 0,
  `image_url` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `user_id`, `mobile_number`, `email`, `password`, `DoB`, `gender`, `status`, `accessed_at`, `updated_at`, `city`, `state`, `is_admin`, `image_url`) VALUES
(1, 'sudoadmin', '222', '0123456789', 'sudo@serverdna.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '0000-00-00', 'male', 'authenticated', '2020-05-08 00:00:00', '2020-06-08 20:23:58', 'Petaling Jaya', 'SARAWAK', 1, NULL),
(2, 'ad', '333', '0123456710', 'ad@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '0000-00-00', 'male', 'authenticated', '2020-05-08 00:00:00', '2020-06-08 20:23:58', 'Puchong', 'SELANGOR', 0, NULL),
(3, 'ad2', '444', '0123456711', 'ad123@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '0000-00-00', 'male', 'authenticated', '2020-05-08 00:00:00', '2020-06-08 20:23:58', 'Puchong', 'SELANGOR', 0, NULL),
(4, 'ad3', '555', '0123456712', 'ad234@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '0000-00-00', 'male', 'authenticated', '2020-05-08 00:00:00', '2020-06-08 20:23:58', 'Puchong', 'SELANGOR', 0, NULL),
(5, 'ad4', '666', '0123456713', 'ad345@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '0000-00-00', 'male', 'authenticated', '2020-05-08 00:00:00', '2020-06-08 20:23:58', 'Puchong', 'SELANGOR', 0, NULL),
(58, 'Jonathan Foong', 'Rexofoam', '0147355823', 'jonathanfoong1997@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1997-09-20', 'male', 'authenticated', NULL, '2020-08-05 00:08:00', 'Petaling Jaya', 'SELANGOR', 0, '../public/images/5f15cd082a7ae3.02525813.jpg'),
(63, 'Tiffany Tan', 'Tiff', '0123093882', 'tiffanytan1995@gmail.com', '209cc77e095e2064e5c1f38817b602f69fb872a1', '2020-08-12', 'male', 'created', NULL, '2020-08-05 00:05:19', 'Petaling Jaya', 'SELANGOR', 0, '../public/images/5f29873ac263b2.28353785.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_events`
--

CREATE TABLE `user_events` (
  `id` int(11) NOT NULL,
  `ev_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('admin','staff','player') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_teams`
--

CREATE TABLE `user_teams` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('captain','vice','player','substitute','') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `status` enum('pending','accepted','rejected','') COLLATE utf8_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_teams`
--

INSERT INTO `user_teams` (`id`, `team_id`, `user_id`, `role`, `created_at`, `status`, `delete_at`) VALUES
(1, 1, 58, 'captain', '2020-07-21 21:04:37', 'pending', NULL),
(2, 1, 3, 'player', '2020-07-21 21:04:37', 'pending', NULL),
(3, 1, 5, 'substitute', '2020-07-21 21:04:37', 'pending', NULL),
(38, 12, 3, 'captain', '2020-08-08 23:15:19', 'pending', NULL),
(39, 12, 5, 'vice', '2020-08-08 23:15:19', 'pending', NULL),
(40, 12, 58, 'player', '2020-08-08 23:15:19', 'pending', NULL),
(41, 12, 63, 'player', '2020-08-08 23:15:19', 'pending', NULL),
(42, 12, 4, 'substitute', '2020-08-08 23:15:19', 'pending', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`ev_id`);

--
-- Indexes for table `event_application`
--
ALTER TABLE `event_application`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_events`
--
ALTER TABLE `user_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_teams`
--
ALTER TABLE `user_teams`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `ev_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_application`
--
ALTER TABLE `event_application`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `user_events`
--
ALTER TABLE `user_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_teams`
--
ALTER TABLE `user_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
