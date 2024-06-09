-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2024 at 06:46 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expensia`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `a_id` int(100) NOT NULL,
  `aname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`a_id`, `aname`, `username`, `password`) VALUES
(1, 'Meraj Alam', 'meraj', '1234'),
(2, 'Atlanta', 'atlantagogoi', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `c_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `u_id` int(15) NOT NULL,
  `creator` varchar(100) NOT NULL,
  `datetime` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`c_id`, `name`, `u_id`, `creator`, `datetime`) VALUES
(57, 'Traveling', 31, 'atlanta2000', '19-05-2024'),
(58, 'Food', 31, 'atlanta2000', '19-05-2024'),
(59, 'Cloths', 31, 'atlanta2000', '19-05-2024'),
(60, 'Utility', 31, 'atlanta2000', '19-05-2024'),
(61, 'Savings', 31, 'atlanta2000', '19-05-2024'),
(62, 'Debt', 31, 'atlanta2000', '19-05-2024'),
(63, 'Entertainment', 31, 'atlanta2000', '19-05-2024'),
(64, 'Housing', 31, 'atlanta2000', '19-05-2024'),
(65, 'Traveling', 27, 'admin123', '21-05-2024');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `e_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datetime` varchar(100) NOT NULL,
  `ex_amount` decimal(10,2) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `ex_comment` varchar(1100) NOT NULL,
  `balance` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`e_id`, `user_id`, `datetime`, `ex_amount`, `cat_name`, `ex_comment`, `balance`) VALUES
(136, 31, '18-05-2024', '350.00', 'Entertainment', 'movies', 24650),
(137, 31, '15-05-2024', '499.00', 'Cloths', 'T-shirt', 24151),
(138, 31, '12-05-2024', '850.00', 'Traveling', 'Moran', 23301),
(139, 31, '15-05-2024', '2400.00', 'Housing', 'Hostel Fees', 20901),
(140, 31, '10-05-2024', '252.00', 'Food', 'Food', 20649),
(141, 31, '04-05-2024', '399.00', 'Food', 'Biryani', 20250),
(142, 31, '04-05-2024', '179.00', 'Food', 'Ice-Cream', 20071),
(143, 31, '18-05-2024', '4099.00', 'Debt', 'EMI', 15972),
(144, 31, '08-05-2024', '799.00', 'Entertainment', 'Movies', 15173),
(145, 31, '19-05-2024', '350.00', 'Food', 'this week\'s samosa, chai', 14823),
(146, 31, '20-05-2024', '4000.00', 'Savings', 'For trip', 10823),
(147, 31, '11-05-2024', '35.00', 'Food', 'Baidew\'s maggi-poach', 10788),
(148, 31, '09-05-2024', '35.00', 'Food', 'maggi-poach', 10753),
(149, 31, '19-05-2024', '89.00', 'Food', 'Soft Drink', 10664),
(150, 31, '09-05-2024', '250.00', 'Utility', 'Mobile Recharge', 10414),
(151, 31, '21-05-2024', '40.00', 'Traveling', 'Town', 10374),
(152, 31, '19-05-2024', '870.00', 'Cloths', 'T-shirt', 9504),
(153, 31, '19-05-2024', '221.00', 'Entertainment', 'Novel', 9283),
(154, 31, '04-04-2024', '1600.00', 'Housing', 'rent', 7683),
(155, 31, '06-05-2024', '120.00', 'Food', 'Mini Dhaba', 7563),
(156, 31, '25-04-2024', '1000.00', 'Utility', 'skin care', 6563),
(157, 31, '22-04-2024', '800.00', 'Traveling', 'Home to Jorhat\r\n', 5763);

-- --------------------------------------------------------

--
-- Table structure for table `query`
--

CREATE TABLE `query` (
  `q_id` int(100) NOT NULL,
  `query_person` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `message` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `query`
--

INSERT INTO `query` (`q_id`, `query_person`, `email`, `message`) VALUES
(7, 'Aliester ali', 'Alister@gmail.com', 'It would be really helpful if we had a mobile app for the expense management system. This way, we could upload receipts and manage our expenses on the go, especially when traveling for business.'),
(8, 'shubhalina kakaty', 'shubha@gmail.com', 'I just wanted to say that the new user interface is fantastic.'),
(9, 'Meraj Alam', 'mera@gmail.com', 'sdsadsa'),
(10, 'dsada adsdsa', 'wondernetyt@gmail.com', 'fsafa');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `u_id` int(100) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(300) NOT NULL,
  `status` varchar(3) NOT NULL,
  `profileImage` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`u_id`, `uname`, `username`, `password`, `email`, `status`, `profileImage`) VALUES
(27, 'Meraj Alam', 'admin123', '4321', 'alamm1940@gmail.com', 'ON', 'WhatsApp Image 2024-03-31 at 12.48.32 AM.jpeg'),
(31, 'Atlanta Gogoi', 'atlanta2000', '1234', 'atlanta@gogoi.com', 'ON', 'Melissa-OToole-MD-300x300.jpg'),
(33, 'Hostel-1', 'numero_uno', '1234', 'numeroUno@gmail.com', 'OFF', 'logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `w_id` int(10) NOT NULL,
  `amount` int(15) NOT NULL,
  `daily` int(15) NOT NULL,
  `weekly` int(15) NOT NULL,
  `monthly` int(15) NOT NULL,
  `u_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`w_id`, `amount`, `daily`, `weekly`, `monthly`, `u_id`) VALUES
(28, 52041, 0, 0, 0, 27),
(31, 5763, 0, 0, 0, 31);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`e_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `query`
--
ALTER TABLE `query`
  ADD PRIMARY KEY (`q_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`w_id`),
  ADD KEY `u_id` (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `a_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `e_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `query`
--
ALTER TABLE `query`
  MODIFY `q_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `u_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `w_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`u_id`);

--
-- Constraints for table `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
