-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 08, 2024 at 04:58 PM
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
(0, 4, '2024-05-04 21:00:33'),
(0, 6, '2024-05-07 20:58:05'),
(0, 1695515135, '2024-05-07 20:59:01'),
(1343409787, 1, '2024-05-07 22:01:45');

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
(0, 1, '2024-05-08 14:19:09'),
(0, 1343409787, '2024-05-07 23:48:27'),
(1, 0, '2024-05-01 21:46:24'),
(132219818, 0, '2024-05-07 21:11:36'),
(1343409787, 0, '2024-05-07 21:13:52');

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
(0, 1695515135, '2024-05-08 14:40:17'),
(1, 1, '2024-05-04 20:09:41'),
(1343409787, 1695515135, '2024-05-07 22:30:52');

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
(4, 0, 1, 'quote', 'This is a test quote repost.', '2024-05-04 20:43:24', NULL),
(6, 1, 1, 'quote', 'This is a test quote post ', '2024-05-04 20:54:00', NULL),
(39504765, 0, 6, 'reply', 'This is a test of the reply feature - with an image ', '2024-05-07 19:29:11', NULL),
(190824172, 0, 6, 'reply', 'This is a second test of the reply feature.', '2024-05-07 19:25:50', NULL),
(239581079, 0, 6, 'reply', 'This is a third test of the reply feature.', '2024-05-07 19:28:42', NULL),
(520363793, 0, NULL, 'main', 'This is a test of the posting feature.', '2024-05-07 19:11:11', NULL),
(726472045, 0, NULL, 'main', 'This is a test', '2024-05-08 14:16:02', NULL),
(759562287, 0, 1695515135, 'reply', 'Very interesting!', '2024-05-07 23:05:03', NULL),
(820149612, 0, 947438389, 'quote', 'This is a test of the quote repost feature', '2024-05-08 16:35:16', NULL),
(947438389, 1343409787, NULL, 'main', 'This is a test tweet', '2024-05-07 22:36:09', NULL),
(989085731, 0, 1639455154, 'quote', 'repost', '2024-05-08 16:46:15', NULL),
(1048254187, 0, 1695515135, 'quote', 'This is a test of the quote repost feature; reposting a post that has an image, with an image', '2024-05-08 16:36:30', 'uploads/5283Mo Salah celebrating.jpg'),
(1639455154, 0, 726472045, 'quote', 'test quote repost number 9238490234', '2024-05-08 16:42:11', NULL),
(1695515135, 0, NULL, 'main', 'This is a test post using the post feature with an image', '2024-05-07 19:36:36', 'uploads/salah vs everton.jpeg'),
(1995665689, 0, 726472045, 'quote', 'lorem ipsum', '2024-05-08 16:40:49', NULL),
(2007749404, 0, 6, 'reply', 'This is a second test of the reply feature with an image', '2024-05-07 19:35:42', 'uploads/salah vs man city.jpeg');

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
(0, 947438389, '2024-05-08 00:22:57'),
(1343409787, 520363793, '2024-05-07 23:35:54');

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
(0, 'marwanzaki05', '482c811da5d5b4bc6d497ffa98491e38', 'MZ', 'about meeeeeee', 'uploads/7982Mo Salah celebrating.jpg', '2024-05-01', NULL, NULL, 'moderator'),
(1, 'mtarek', '3193150bfbe7f1ffea91740b124ff236', 'Mohamed Tarek', '', 'images/pexels-pixabay-45201.jpg', '2024-05-01', NULL, NULL, 'regular'),
(132219818, 'marwanzaki2005', '482c811da5d5b4bc6d497ffa98491e38', 'Marwan Zaki', '', 'images/profile_unkown.png', '2024-05-06', NULL, NULL, 'regular'),
(1343409787, 'mtarek2005', '482c811da5d5b4bc6d497ffa98491e38', 'Mohamed Tarek 2005', '', 'images/profile_unkown.png', '2024-05-07', NULL, NULL, 'regular');

--
-- Indexes for dumped tables
--

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
  ADD KEY `post_replied_to` (`Post_replied_to`),
  ADD KEY `poster` (`Poster`);

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
-- Constraints for table `PMs`
--
ALTER TABLE `PMs`
  ADD CONSTRAINT `from_user` FOREIGN KEY (`From_user`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE,
  ADD CONSTRAINT `to_user` FOREIGN KEY (`To_user`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE;

--
-- Constraints for table `Post`
--
ALTER TABLE `Post`
  ADD CONSTRAINT `post_replied_to` FOREIGN KEY (`Post_replied_to`) REFERENCES `Post` (`PostID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `poster` FOREIGN KEY (`Poster`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Reposts`
--
ALTER TABLE `Reposts`
  ADD CONSTRAINT `reposted` FOREIGN KEY (`Post`) REFERENCES `Post` (`PostID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reposter` FOREIGN KEY (`User`) REFERENCES `Users` (`UUID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
