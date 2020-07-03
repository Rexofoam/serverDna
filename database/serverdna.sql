-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2020 at 02:24 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `delete_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_game`
--

CREATE TABLE `team_game` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `delete_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tournament`
-- NOTE: Gonna replace this with an 'event' table so that it can potentially capture more types of events in the future

-- CREATE TABLE `tournament` (
--   `id` int(11) NOT NULL,
--   `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
--   `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
--   `start_datetime` datetime NOT NULL,
--   `end_datetime` datetime NOT NULL,
--   `created_at` datetime NOT NULL,
--   `updated_at` datetime NOT NULL,
--   `deleted_at` datetime DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `ev_id` int(11) NOT NULL,
  `ev_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ev_description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ev_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL, -- Event type (tournament/talk/pubstomp/etc) different events may be included at another time
  `game_id` int(11),
  `reg_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL, -- Registration type (TEAMS or INDIVIDUAL)
  `reg_max_count` int(3) NOT NULL,
  `reg_cur_count` int(3) DEFAULT 0,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `venue` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `organisers` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ev_admins` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ev_staff` varchar(100) COLLATE utf8_unicode_ci,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `approved_by` int(11) NOT NULL,
  `app_id` int (11),
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
  `game_id` int(11),
  `team_count` int(3),
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `venue` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `organiser` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `contact_method` varchar(50) COLLATE utf8_unicode_ci,
  `contact_no` varchar(15) COLLATE utf8_unicode_ci,
  `contact_email` varchar(100) COLLATE utf8_unicode_ci,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status_upd_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `event_application` (`app_id`, `app_name`, `app_description`, `game_id`, `team_count`, `start_datetime`, `end_datetime`, `venue`, `city`, `state`, `organiser`, `created_by`, `contact_method`, `contact_no`, `contact_email`, `status`, `event_id`, `deleted_at`) VALUES
(1, 'Some Dota 2 Tournament with a randomly long name', 'Some Dota 2 Tournament with a randomly long name', '222', '16', '2020-06-11', '2020-06-13', 'Taylor\'s University', 'Petaling Jaya', 'Selangor', 'ONE Esports', '1', 
'Email', '0186632500', 'oneesports@gmail.com', 'pending', NULL);


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
  `is_admin` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `user_id`, `mobile_number`, `email`, `password`, `DoB`, `gender`, `status`, `accessed_at`, `updated_at`, `city`, `state`, `is_admin`) VALUES
(1, 'sudoadmin', '222', '0123456789', 'sudo@serverdna.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '0000-00-00', 'male', 'authenticated', '2020-05-08 00:00:00', '2020-06-08 20:23:58', 'Petaling Jaya', 'SARAWAK', '1');

INSERT INTO `users` (`id`, `full_name`, `user_id`, `mobile_number`, `email`, `password`, `DoB`, `gender`, `status`, `accessed_at`, `updated_at`, `city`, `state`, `is_admin`) VALUES
(2, 'ad', '333', '0123456789', 'ad@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '0000-00-00', 'male', 'authenticated', '2020-05-08 00:00:00', '2020-06-08 20:23:58', 'Puchong', 'SELANGOR', '0');

-- --------------------------------------------------------

--
-- Table structure for table `user_teams`
--

CREATE TABLE `user_teams` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('captain','vice','player','') COLLATE utf8_unicode_ci NOT NULL,
  `delete_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tournament`
--

CREATE TABLE `user_tournament` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `role` enum('sudoadmin','tournament_admin','staff','player') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_game`
--
ALTER TABLE `team_game`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tournament`
--
ALTER TABLE `tournament`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_application`
--
ALTER TABLE `event_application`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_teams`
--
ALTER TABLE `user_teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_tournament`
--
ALTER TABLE `user_tournament`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_game`
--
ALTER TABLE `team_game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tournament`
--
ALTER TABLE `tournament`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_application`
--
ALTER TABLE `event_application`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `user_teams`
--
ALTER TABLE `user_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_tournament`
--
ALTER TABLE `user_tournament`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
