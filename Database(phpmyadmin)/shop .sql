-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2021 at 08:48 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(5, 'Cell Phones', 'new and good phones', 5, 0, 0, 0),
(12, 'Electronics', 'Any kind of electronics', 0, 0, 0, 0),
(13, 'Fashion', 'clothes and Fashion', 2, 0, 0, 0),
(14, 'TVs', 'all kind of Tvs', 3, 0, 0, 0),
(16, 'Sports', 'all kind of sporrts tools', 6, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` int(11) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` text NOT NULL,
  `add_date` date NOT NULL,
  `country_made` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(225) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `cate_ID` int(11) NOT NULL,
  `member_ID` int(11) NOT NULL,
  `approve` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `description`, `price`, `add_date`, `country_made`, `image`, `status`, `rating`, `cate_ID`, `member_ID`, `approve`) VALUES
(1, 'iphone 6 plus', 'The phone comes with a 5.50-inch touchscreen display with a resolution of 1080x1920 pixels at a pixel density of 401 pixels per inch (ppi). Apple iPhone 6s Plus is powered by an one-core Apple A9 processor. It comes with 2GB of RAM. The Apple iPhone 6s Plus runs iOS 9 and is powered by a 2750mAh non-removable battery.\r\n', '477.59', '2021-04-01', 'USA', '', '1', 5, 5, 113, 1),
(2, 'boAt Airdopes 701ANC Hybrid', 'Battery: Airdopes 701ANC offers a playback time of up to 5.5 hours in earbuds & 22 hours in charging case\r\nBluetooth: It has Bluetooth v5.0 with a range of 15m and is compatible with Android & iOS\r\nIP rating: It has an IPX7 marked water & sweat resistance', '40', '2021-04-02', 'India', '', '1', 4, 12, 113, 1),
(14, 'Sollatek UPS - power back 850 va', 'BrandSollatek Manufacturer Numberpower back 850 va Package thickness18.4 centimeters Package weight in KGs0.94 kilograms', '150', '2021-04-24', 'Germany', '', '1', 0, 12, 1, 0),
(15, 'Nikon COOLPIX B500 ', 'Capture stunning photos and videos and share special ', '200', '2021-04-24', 'USA', '', '1', 0, 12, 1, 0),
(16, 'Anker A1277H11 Power Bank ', 'Brand: Anker Model: A1277H11 Type: Power bank Battery Capacity: 26800 mAh Number of charging ports: 3 Color: Black Power Bank Compatible with most mobile devices. Fast Charge and safe to use. Unique and simple design. Light weight and easy to carry.', '50', '2021-04-24', 'USA', '', '1', 0, 12, 1, 0),
(17, 'LG 55 inches UHD 4K Smart TV', 'Brand: LG\r\nModel: 55UP7550PVG\r\nType of processor: A5 AI Processor 4K\r\nNumber of sound channels: 2\r\nDesign: Cinema screen', '200', '2021-04-08', 'EGY', '', '1', 0, 14, 1, 1),
(21, 'Football', 'good one', '20', '2021-04-29', 'usa', '', '1', 0, 16, 112, 0),
(22, 'T-shirt', 'cool shirt with lot&#39;s of colors ', '5', '2021-04-29', 'rgy', '', '1', 0, 13, 113, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL COMMENT 'username to login',
  `password` varchar(255) NOT NULL COMMENT 'password to login',
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `groupID` int(11) NOT NULL DEFAULT 0 COMMENT 'identify user from admin',
  `trust_status` int(11) NOT NULL DEFAULT 0 COMMENT 'seller rank',
  `reg_status` int(11) NOT NULL DEFAULT 0 COMMENT 'user approval',
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`, `email`, `fullname`, `groupID`, `trust_status`, `reg_status`, `Date`) VALUES
(1, 'eslamyomi', '5e03bffa966bc535c816e86b77af80106e5608bd', 'eslamabdallah301@gmail.com', 'Eslam abdallah', 1, 0, 1, '2021-04-18'),
(3, 'Hzamora', '48f95adcdd2d1d9b1da95a0e676fea740d73adad', 'eslamabdallah301@gmail.com', 'Karem Ahmed abdallah', 0, 0, 1, '2021-04-18'),
(4, 'ona', '01dad94b9385ec1452547f55868a4c33515d044b', 'dasdsa@dsad', 'eman amin', 0, 0, 1, '2021-04-18'),
(5, 'man2awar', '78c988f6a554eedabd7d88c781ab7f6db5f405cb', 'eslamabdallah301@gmail.com', 'Ahmed Abdallah', 0, 0, 1, '2021-04-18'),
(6, 'Salama', 'e447c35316426c234c336ce24f3fc0d4226220c0', 'dfsadas2@yahoo.com', 'salam mohamed', 0, 0, 1, '2021-04-18'),
(11, 'lucas', '61ff76c0a46c9f653f4b1ee3d251aac860263e15', 'AlaaElo@gamil.com', 'Alaa elsayed', 0, 0, 1, '2021-04-21'),
(112, 'user', '5e03bffa966bc535c816e86b77af80106e5608bd', 'user@yahoo.com', 'User', 0, 0, 0, '2021-04-26'),
(113, 'eslamabdallah', '5e03bffa966bc535c816e86b77af80106e5608bd', 'yomi@gmail', 'Eslam abdallah abass', 0, 0, 1, '2021-04-26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `user_comment` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `memberLink` (`member_ID`),
  ADD KEY `cateLink` (`cate_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_comment` FOREIGN KEY (`user_id`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cateLink` FOREIGN KEY (`cate_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `memberLink` FOREIGN KEY (`member_ID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
