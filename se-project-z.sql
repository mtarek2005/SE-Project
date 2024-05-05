-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 05, 2024 at 10:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `se-project-z`
--

-- --------------------------------------------------------

--
-- Table structure for table `Blocks`
--

DROP TABLE IF EXISTS `Blocks`;
CREATE TABLE `Blocks` (
  `Blocker` int(11) NOT NULL,
  `Blocked` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Blocks`
--

INSERT INTO `Blocks` (`Blocker`, `Blocked`) VALUES
(0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Bookmarks`
--

DROP TABLE IF EXISTS `Bookmarks`;
CREATE TABLE `Bookmarks` (
  `User` int(11) NOT NULL,
  `Post` int(11) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Bookmarks`
--

INSERT INTO `Bookmarks` (`User`, `Post`, `Date`) VALUES
(0, 1, '2024-05-04 00:01:48'),
(0, 2, '2024-05-04 21:00:43'),
(0, 4, '2024-05-04 21:00:33');

-- --------------------------------------------------------

--
-- Table structure for table `Follows`
--

DROP TABLE IF EXISTS `Follows`;
CREATE TABLE `Follows` (
  `Follower` int(11) NOT NULL,
  `Followed` int(11) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Follows`
--

INSERT INTO `Follows` (`Follower`, `Followed`, `Date`) VALUES
(0, 1, '2024-05-01 21:45:51'),
(1, 0, '2024-05-01 21:46:24');

-- --------------------------------------------------------

--
-- Table structure for table `Likes`
--

DROP TABLE IF EXISTS `Likes`;
CREATE TABLE `Likes` (
  `User` int(11) NOT NULL,
  `Post` int(11) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Likes`
--

INSERT INTO `Likes` (`User`, `Post`, `Date`) VALUES
(0, 2, '2024-05-04 20:11:51'),
(1, 1, '2024-05-04 20:09:41');

-- --------------------------------------------------------

--
-- Table structure for table `Mutes`
--

DROP TABLE IF EXISTS `Mutes`;
CREATE TABLE `Mutes` (
  `Muter` int(11) NOT NULL,
  `Muted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Mutes`
--

INSERT INTO `Mutes` (`Muter`, `Muted`) VALUES
(0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `PMs`
--

DROP TABLE IF EXISTS `PMs`;
CREATE TABLE `PMs` (
  `MessageID` int(11) NOT NULL,
  `From_user` int(11) NOT NULL,
  `To_user` int(11) NOT NULL,
  `Content` text NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `Reaction` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `PMs`
--

INSERT INTO `PMs` (`MessageID`, `From_user`, `To_user`, `Content`, `Date`, `Reaction`) VALUES
(827757441, 1, 0, 'This is a test message', '2024-05-04 21:25:04', '💩'),
(1161868969, 0, 1, 'This is a test reply to that message', '2024-05-04 21:25:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Post`
--

DROP TABLE IF EXISTS `Post`;
CREATE TABLE `Post` (
  `PostID` int(11) NOT NULL,
  `Poster` int(11) NOT NULL,
  `Post_replied_to` int(11) DEFAULT NULL,
  `Post_type` enum('main','reply','quote') NOT NULL,
  `Content` text NOT NULL,
  `Post_date` datetime NOT NULL DEFAULT current_timestamp(),
  `Image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Post`
--

INSERT INTO `Post` (`PostID`, `Poster`, `Post_replied_to`, `Post_type`, `Content`, `Post_date`, `Image`) VALUES
(1, 0, NULL, 'main', 'This is a test post', '2024-05-03 21:01:46', NULL),
(2, 0, 1, 'reply', 'This is a test reply.', '2024-05-03 22:26:22', NULL),
(3, 0, NULL, 'main', 'This is a test post bla bla bla', '2024-05-04 20:42:42', 'images/pexels-mikebirdy-170811.jpg'),
(4, 0, 1, 'quote', 'This is a test quote repost.', '2024-05-04 20:43:24', NULL),
(5, 1, NULL, 'main', 'This is a test post', '2024-05-04 20:53:32', NULL),
(6, 1, 1, 'quote', 'This is a test quote post ', '2024-05-04 20:54:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Reposts`
--

DROP TABLE IF EXISTS `Reposts`;
CREATE TABLE `Reposts` (
  `User` int(11) NOT NULL,
  `Post` int(11) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Reposts`
--

INSERT INTO `Reposts` (`User`, `Post`, `Date`) VALUES
(0, 1, '2024-05-03 22:36:33'),
(1, 3, '2024-05-04 20:54:56');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
  `UUID` int(11) NOT NULL,
  `Username` text NOT NULL,
  `Hashed_password` text NOT NULL,
  `Display_name` text DEFAULT '',
  `About` text DEFAULT '',
  `Profile_pic` text DEFAULT 'images/profile_unkown.png',
  `Join_date` date NOT NULL DEFAULT current_timestamp(),
  `Mute_to` datetime DEFAULT NULL,
  `Ban_to` datetime DEFAULT NULL,
  `Role` enum('regular','moderator') NOT NULL DEFAULT 'regular'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UUID`, `Username`, `Hashed_password`, `Display_name`, `About`, `Profile_pic`, `Join_date`, `Mute_to`, `Ban_to`, `Role`) VALUES
(0, 'marwanzaki', '482c811da5d5b4bc6d497ffa98491e38', 'Marwan Zaki', 'about me', 'images/profile_unkown.png', '2024-05-01', NULL, NULL, 'regular'),
(1, 'mtarek', '3193150bfbe7f1ffea91740b124ff236', 'Mohamed Tarek', '', 'images/profile_unkown.png', '2024-05-01', NULL, NULL, 'regular');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Blocks`
--
ALTER TABLE `Blocks`
  ADD PRIMARY KEY (`Blocker`,`Blocked`),
  ADD KEY `blocked` (`Blocked`);

--
-- Indexes for table `Bookmarks`
--
ALTER TABLE `Bookmarks`
  ADD PRIMARY KEY (`User`,`Post`),
  ADD KEY `post_bookmark` (`Post`);

--
-- Indexes for table `Follows`
--
ALTER TABLE `Follows`
  ADD PRIMARY KEY (`Follower`,`Followed`),
  ADD KEY `followed` (`Followed`);

--
-- Indexes for table `Likes`
--
ALTER TABLE `Likes`
  ADD PRIMARY KEY (`User`,`Post`),
  ADD KEY `post_liked` (`Post`);

--
-- Indexes for table `Mutes`
--
ALTER TABLE `Mutes`
  ADD PRIMARY KEY (`Muter`,`Muted`),
  ADD KEY `muted` (`Muted`);

--
-- Indexes for table `PMs`
--
ALTER TABLE `PMs`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `from_user` (`From_user`),
  ADD KEY `to_user` (`To_user`);

--
-- Indexes for table `Post`
--
ALTER TABLE `Post`
  ADD PRIMARY KEY (`PostID`),
  ADD KEY `poster` (`Poster`),
  ADD KEY `post_replied_to` (`Post_replied_to`);

--
-- Indexes for table `Reposts`
--
ALTER TABLE `Reposts`
  ADD PRIMARY KEY (`User`,`Post`),
  ADD KEY `reposted` (`Post`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UUID`),
  ADD UNIQUE KEY `Username` (`Username`) USING HASH;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Blocks`
--
ALTER TABLE `Blocks`
  ADD CONSTRAINT `blocked` FOREIGN KEY (`Blocked`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE,
  ADD CONSTRAINT `blocker` FOREIGN KEY (`Blocker`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE;

--
-- Constraints for table `Bookmarks`
--
ALTER TABLE `Bookmarks`
  ADD CONSTRAINT `post_bookmark` FOREIGN KEY (`Post`) REFERENCES `Post` (`PostID`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_bookmark` FOREIGN KEY (`User`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE;

--
-- Constraints for table `Follows`
--
ALTER TABLE `Follows`
  ADD CONSTRAINT `followed` FOREIGN KEY (`Followed`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE,
  ADD CONSTRAINT `follower` FOREIGN KEY (`Follower`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE;

--
-- Constraints for table `Likes`
--
ALTER TABLE `Likes`
  ADD CONSTRAINT `liker` FOREIGN KEY (`User`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_liked` FOREIGN KEY (`Post`) REFERENCES `Post` (`PostID`) ON DELETE CASCADE;

--
-- Constraints for table `Mutes`
--
ALTER TABLE `Mutes`
  ADD CONSTRAINT `muted` FOREIGN KEY (`Muted`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE,
  ADD CONSTRAINT `muter` FOREIGN KEY (`Muter`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE;

--
-- Constraints for table `PMs`
--
ALTER TABLE `PMs`
  ADD CONSTRAINT `from_user` FOREIGN KEY (`From_user`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE,
  ADD CONSTRAINT `to_user` FOREIGN KEY (`To_user`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE;

--
-- Constraints for table `Post`
--
ALTER TABLE `Post`
  ADD CONSTRAINT `post_replied_to` FOREIGN KEY (`Post_replied_to`) REFERENCES `Post` (`PostID`) ON DELETE CASCADE,
  ADD CONSTRAINT `poster` FOREIGN KEY (`Poster`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE;

--
-- Constraints for table `Reposts`
--
ALTER TABLE `Reposts`
  ADD CONSTRAINT `reposted` FOREIGN KEY (`Post`) REFERENCES `Post` (`PostID`),
  ADD CONSTRAINT `reposter` FOREIGN KEY (`User`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
