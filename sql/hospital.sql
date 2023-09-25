-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2023 at 04:33 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `current_datetime` datetime DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `HN` varchar(10) NOT NULL,
  `ID_number` varchar(13) DEFAULT NULL,
  `S_name` varchar(255) DEFAULT NULL,
  `booked_by` varchar(255) DEFAULT NULL,
  `Department` varchar(255) DEFAULT NULL,
  `P_number` varchar(10) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `room` varchar(20) NOT NULL,
  `Status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`current_datetime`, `appointment_date`, `HN`, `ID_number`, `S_name`, `booked_by`, `Department`, `P_number`, `Email`, `room`, `Status`) VALUES
('2023-09-19 22:57:46', '2023-09-21', '6310210013', '1839400000000', 'ศาสตราวุธ ผงเผ่า', 'มาโนช ชัพพลาย', 'เด็ก', '0816452112', 'hamsusu@gmail.com', 'ห้องพักแบบพิเศษ 2', 'รออนุมัติ'),
('2023-09-20 18:35:59', '2023-09-23', '6310210160', '1839900642600', 'จักกรี อารี', 'สายฝน กลางคืน', 'หู คอ จมูก', '0813246551', 'somchar@gmail.com', 'ห้องพักแบบพิเศษ 1', 'รออนุมัติ'),
('2023-09-21 02:58:04', '2023-09-23', '6310210403', '1830101151811', 'สมสาย มานีนา', 'สาสม ออเก้า', 'อายุรกรรม', '0646215488', 'gamekak12@gmail.com', 'ห้องพักแบบพิเศษ 1', 'รออนุมัติ');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--
-- Error reading structure for table hospital.department: #1932 - Table 'hospital.department' doesn't exist in engine
-- Error reading data for table hospital.department: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `hospital`.`department`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `m_id` int(10) NOT NULL,
  `m_firstname` varchar(200) NOT NULL,
  `m_lastname` varchar(200) NOT NULL,
  `m_username` varchar(200) NOT NULL,
  `m_password` varchar(200) NOT NULL,
  `m_level` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`m_id`, `m_firstname`, `m_lastname`, `m_username`, `m_password`, `m_level`) VALUES
(1, 'mosskrit', 'sakda', 'moss123', '456789', 'admin'),
(2, 'kritza', 'sakda', 'moss789', '789456', 'officer'),
(3, 'popeyeza', 'lol', 'admin1', '123456', 'officer');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `HN` char(15) NOT NULL,
  `p_idcard` varchar(13) DEFAULT NULL,
  `p_fname` varchar(15) CHARACTER SET tis620 COLLATE tis620_thai_ci DEFAULT NULL,
  `p_lname` varchar(15) CHARACTER SET tis620 COLLATE tis620_thai_ci DEFAULT NULL,
  `p_disease` varchar(15) CHARACTER SET tis620 COLLATE tis620_thai_ci DEFAULT NULL,
  `d_id` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`HN`, `p_idcard`, `p_fname`, `p_lname`, `p_disease`, `d_id`) VALUES
('HN-6310210001', '1839100000023', 'มะลิ', 'ใจดี', 'ภูมิเเพ้', 'D-1'),
('HN-6310210002', '1839100000204', 'เเมนนี่', 'ปาเกียว', 'คออักเสบ', 'D-5'),
('HN-6310210003', '1839100000045', 'จำปา', 'มหาสมุทร', 'ต้อลม', 'D-5'),
('HN-6310210403', '1830000000000', 'สิทธิชัย', 'องค์วิมลการ', 'เบาหวาน', 'D-2');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `HN` varchar(255) NOT NULL,
  `S_name` varchar(255) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `ID_number` varchar(255) NOT NULL,
  `P_number` varchar(20) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `HN`, `S_name`, `Department`, `ID_number`, `P_number`, `Email`) VALUES
(1, '6310210403', 'สมสาย มานีนา', 'อายุรกรรม', '1830101151811', '0646215488', 'monthree@gmail.com'),
(2, '6310210013', 'ศาสตราวุธ ผงเผ่า', 'เด็ก', '1839400000000', '0646215488', 'hamsusu@gmail.com'),
(3, '6310210160', 'จักกรี อารี', 'หู คอ จมูก', '1839900642600', '0813246551', 'hamsusu@gmail.com'),
(4, '6310210444', 'จักกรี อารี', 'อายุรกรรม', '1830101151147', '0813246544', 'monthree@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `r_id` char(10) CHARACTER SET armscii8 COLLATE armscii8_general_ci NOT NULL,
  `r_name` varchar(15) CHARACTER SET tis620 COLLATE tis620_thai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`r_id`, `r_name`) VALUES
('R-1', 'ราคาประหยัด'),
('R-2', 'พิเศษ 1'),
('R-3', 'พิเศษ 2');

-- --------------------------------------------------------

--
-- Table structure for table `room_num`
--

CREATE TABLE `room_num` (
  `rn_id` int(10) NOT NULL,
  `rt_id` int(10) NOT NULL,
  `rn_name` varchar(200) CHARACTER SET armscii8 COLLATE armscii8_bin NOT NULL,
  `rn_status` varchar(200) CHARACTER SET tis620 COLLATE tis620_thai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_num`
--

INSERT INTO `room_num` (`rn_id`, `rt_id`, `rn_name`, `rn_status`) VALUES
(1, 1, 'Room-1', 'ห้องว่าง'),
(2, 3, 'Room-2', 'ห้องว่าง'),
(3, 2, 'Room-3', 'ห้องว่าง'),
(4, 3, 'Room-4', 'ห้องว่าง'),
(12, 13, 'Room-5', 'ห้องไม่ว่าง');

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE `room_type` (
  `rt_id` int(10) NOT NULL,
  `rt_type` varchar(200) CHARACTER SET tis620 COLLATE tis620_thai_ci NOT NULL,
  `rt_price` varchar(200) CHARACTER SET tis620 COLLATE tis620_thai_ci NOT NULL,
  `rt_img` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_type`
--

INSERT INTO `room_type` (`rt_id`, `rt_type`, `rt_price`, `rt_img`) VALUES
(1, 'พิเศษ 1', '2500', '164299518.jpg'),
(2, 'พิเศษ 2', '4000', '1698634197.jpg'),
(3, 'ราคาประหยัด 1', '400', '1019634679.jpg'),
(13, 'ราคาประหยัด 2', '600', '1374815459.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`HN`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`HN`),
  ADD KEY `d_id` (`d_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `room_num`
--
ALTER TABLE `room_num`
  ADD PRIMARY KEY (`rn_id`),
  ADD KEY `rt_id` (`rt_id`);

--
-- Indexes for table `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`rt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `m_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room_num`
--
ALTER TABLE `room_num`
  MODIFY `rn_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `rt_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`d_id`) REFERENCES `department` (`d_id`);

--
-- Constraints for table `room_num`
--
ALTER TABLE `room_num`
  ADD CONSTRAINT `rt_id` FOREIGN KEY (`rt_id`) REFERENCES `room_type` (`rt_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
