-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2023 at 08:33 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cwk2`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `commentID` int(10) NOT NULL,
  `commentDescription` varchar(500) DEFAULT NULL,
  `createdTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `postID` int(10) DEFAULT NULL,
  `userID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`commentID`, `commentDescription`, `createdTime`, `postID`, `userID`) VALUES
(1, 'cute', '2023-01-24 14:58:18', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `postID` int(10) NOT NULL,
  `image` varchar(255) NOT NULL,
  `likesCount` int(100) DEFAULT NULL,
  `caption` varchar(500) DEFAULT NULL,
  `createdTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `userID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postID`, `image`, `likesCount`, `caption`, `createdTime`, `userID`) VALUES
(1, 'd44add5cc7d28e6d2901a4a91575e483.jpg', NULL, 'puppyy', '2023-01-24 14:57:56', 1),
(3, 'e3a6ede54fb0afb93420800d3b7d2b34.jpg', NULL, 'natureeeeeeeeeeee', '2023-01-24 14:59:28', 1),
(5, '0aa37be0ba0f48cacd21a97d706af7b7.jpg', NULL, 'beeeeeeeeeeeeeech', '2023-01-24 15:00:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_tag`
--

CREATE TABLE `post_tag` (
  `tagID` int(10) NOT NULL,
  `postID` int(10) NOT NULL,
  `createdTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post_tag`
--

INSERT INTO `post_tag` (`tagID`, `postID`, `createdTime`) VALUES
(1, 1, '2023-01-24 14:57:56'),
(3, 3, '2023-01-24 14:59:28'),
(5, 5, '2023-01-24 15:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tagID` int(10) NOT NULL,
  `tag` varchar(100) DEFAULT NULL,
  `createdTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tagID`, `tag`, `createdTime`) VALUES
(1, 'puppy', '2023-01-24 14:57:56'),
(2, 'puppy', '2023-01-24 14:59:23'),
(3, 'puppy', '2023-01-24 14:59:28'),
(4, 'beach', '2023-01-24 14:59:57'),
(5, 'beach', '2023-01-24 15:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(10) NOT NULL,
  `profilePic` varchar(255) DEFAULT NULL,
  `userType` int(2) DEFAULT NULL,
  `userAddress` varchar(500) DEFAULT NULL,
  `userTelNo` int(10) DEFAULT NULL,
  `fullName` varchar(50) DEFAULT NULL,
  `userName` varchar(50) NOT NULL,
  `userDescription` varchar(1000) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `profilePic`, `userType`, `userAddress`, `userTelNo`, `fullName`, `userName`, `userDescription`, `email`, `password`) VALUES
(1, '4d249e60333a55f9e018a8687376e60a.jpg', NULL, NULL, NULL, NULL, 'Nanduni Gajanayake', 'aaaaaaaaaaa', 'nanduni.20191258@iit.ac.lk', '$2y$10$75oFKGEUBGGeiFCDfjz2EuF8BW7kP2Ry/vIjEq3FMrgHmEjYcwkkW'),
(2, NULL, NULL, NULL, NULL, NULL, 'max', '', 'max@gmail.com', '$2y$10$DFL3kEWSYqabNU8qwgeLceF8kYNhtZOcg9zhXZSH.bc0L.zcdDwFG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `COMMENT1_FK` (`postID`),
  ADD KEY `COMMENT2_FK` (`userID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postID`),
  ADD UNIQUE KEY `image` (`image`),
  ADD KEY `POST_FK` (`userID`);

--
-- Indexes for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`tagID`,`postID`),
  ADD KEY `HASHTAG_POST2_FK` (`postID`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tagID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userName` (`userName`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `postID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tagID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `COMMENT1_FK` FOREIGN KEY (`postID`) REFERENCES `post` (`postID`),
  ADD CONSTRAINT `COMMENT2_FK` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `POST_FK` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `HASHTAG_POST1_FK` FOREIGN KEY (`tagID`) REFERENCES `tag` (`tagID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `HASHTAG_POST2_FK` FOREIGN KEY (`postID`) REFERENCES `post` (`postID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
