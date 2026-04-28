-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 28, 2026 at 03:17 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `darbic_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `full_name`, `email`, `password`) VALUES
(1, 'Ahmed Al-Rashid', 'ahmed@darbic.com', 'admin123'),
(2, 'Sara Al-Otaibi', 'sara@darbic.com', 'admin1122');

-- --------------------------------------------------------

--
-- Table structure for table `assistancerequest`
--

CREATE TABLE `assistancerequest` (
  `request_id` int(11) NOT NULL,
  `request_type` varchar(100) NOT NULL DEFAULT 'Golf Cart',
  `request_status` varchar(50) NOT NULL DEFAULT 'Pending',
  `request_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `visitor_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assistancerequest`
--

INSERT INTO `assistancerequest` (`request_id`, `request_type`, `request_status`, `request_date`, `visitor_id`, `ticket_id`) VALUES
(1, 'Golf Cart', 'Confirmed', '2026-04-27 10:00:00', 1, 1),
(2, 'Golf Cart', 'Pending', '2026-04-28 09:00:00', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(150) NOT NULL,
  `event_date` date NOT NULL,
  `location` varchar(150) NOT NULL,
  `description` text,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_name`, `event_date`, `location`, `description`, `created_by`) VALUES
(1, 'Riyadh Season Football Final', '2026-05-10', 'King Fahd Stadium, Riyadh', 'Final football match of the Riyadh Season tournament.', 1),
(2, 'Expo 2030 Opening Ceremony', '2026-05-15', 'Expo 2030 Grounds, North Riyadh', 'Grand opening ceremony of Expo 2030.', 1),
(3, 'Saudi National Concert Night', '2026-05-20', 'King Abdullah Sports City', 'National celebration concert featuring top Saudi artists.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `eventhistory`
--

CREATE TABLE `eventhistory` (
  `history_id` int(11) NOT NULL,
  `attended_date` date DEFAULT NULL,
  `visitor_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `eventhistory`
--

INSERT INTO `eventhistory` (`history_id`, `attended_date`, `visitor_id`, `event_id`, `assignment_id`) VALUES
(1, '2026-03-12', 1, 1, 1),
(2, '2026-02-04', 1, 2, 6),
(3, '2026-01-20', 1, 3, 9),
(4, '2026-03-12', 2, 1, 2),
(5, '2026-02-04', 3, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `gate`
--

CREATE TABLE `gate` (
  `gate_id` int(11) NOT NULL,
  `gate_name` varchar(50) NOT NULL,
  `gate_capacity` int(11) NOT NULL,
  `current_load` int(11) DEFAULT '0',
  `zone_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gate`
--

INSERT INTO `gate` (`gate_id`, `gate_name`, `gate_capacity`, `current_load`, `zone_id`) VALUES
(1, 'Gate A1', 300, 110, 1),
(2, 'Gate A2', 300, 90, 1),
(3, 'Gate A3', 400, 200, 1),
(4, 'Gate B1', 500, 140, 2),
(5, 'Gate B2', 500, 300, 2),
(6, 'Gate VIP', 200, 50, 3),
(7, 'Gate C1', 500, 80, 4),
(8, 'Gate C2', 500, 120, 4),
(9, 'Gate D1', 500, 60, 5),
(10, 'Gate D2', 500, 200, 5),
(11, 'Gate VIP', 200, 40, 6),
(12, 'Gate E1', 700, 300, 7),
(13, 'Gate E2', 700, 150, 7),
(14, 'Gate VIP', 200, 30, 8);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `sent_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `visitor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `title`, `message`, `is_read`, `sent_at`, `visitor_id`) VALUES
(1, 'Assignment Updated', 'Your assigned gate has been changed to Gate A1.', 0, '2026-04-28 15:00:00', 1),
(2, 'Pickup Point Updated', 'Your pickup point has been updated to North Parking Area.', 0, '2026-04-28 15:10:00', 1),
(3, 'Arrival Reminder', 'Please arrive at the venue 30 minutes before the event.', 1, '2026-04-28 14:00:00', 1),
(4, 'Golf Cart Confirmed', 'Your Golf Cart assistance request has been confirmed.', 1, '2026-04-27 10:00:00', 1),
(5, 'Crowd Alert', 'North Zone is getting crowded. Please arrive early.', 0, '2026-04-28 16:00:00', 2),
(6, 'Assignment Ready', 'Your gate assignment is ready. Check your dashboard.', 1, '2026-04-28 12:00:00', 2),
(7, 'Arrival Reminder', 'Please arrive at the venue 30 minutes before the event.', 0, '2026-04-28 14:00:00', 3),
(8, 'Assignment Ready', 'Your gate assignment is ready. Gate B1 assigned.', 1, '2026-04-28 12:00:00', 4),
(9, 'VIP Access Confirmed', 'Your VIP access has been confirmed. VIP Gate is ready.', 1, '2026-04-28 11:00:00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` int(11) NOT NULL,
  `ticket_number` varchar(50) NOT NULL,
  `ticket_type` varchar(30) DEFAULT 'Regular',
  `booking_date` date DEFAULT NULL,
  `status` varchar(30) DEFAULT 'Active',
  `visitor_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_id`, `ticket_number`, `ticket_type`, `booking_date`, `status`, `visitor_id`, `event_id`) VALUES
(1, 'T100', 'Regular', '2026-04-20', 'Active', 1, 1),
(2, 'T101', 'Regular', '2026-04-20', 'Active', 2, 1),
(3, 'T102', 'Regular', '2026-04-21', 'Active', 3, 1),
(4, 'VIP01', 'VIP', '2026-04-21', 'Active', 4, 1),
(5, 'VIP02', 'VIP', '2026-04-22', 'Active', 5, 1),
(6, 'T200', 'Regular', '2026-04-25', 'Active', 1, 2),
(7, 'T201', 'Regular', '2026-04-25', 'Active', 2, 2),
(8, 'VIP10', 'VIP', '2026-04-26', 'Active', 3, 2),
(9, 'T300', 'Regular', '2026-04-27', 'Active', 4, 3),
(10, 'VIP20', 'VIP', '2026-04-27', 'Active', 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `timeslot`
--

CREATE TABLE `timeslot` (
  `timeslot_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `slot_date` date NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `timeslot`
--

INSERT INTO `timeslot` (`timeslot_id`, `start_time`, `end_time`, `slot_date`, `event_id`) VALUES
(1, '17:00:00', '17:30:00', '2026-05-10', 1),
(2, '17:30:00', '18:00:00', '2026-05-10', 1),
(3, '18:00:00', '18:30:00', '2026-05-10', 1),
(4, '18:30:00', '19:00:00', '2026-05-10', 1),
(5, '09:00:00', '09:30:00', '2026-05-15', 2),
(6, '09:30:00', '10:00:00', '2026-05-15', 2),
(7, '10:00:00', '10:30:00', '2026-05-15', 2),
(8, '19:00:00', '19:30:00', '2026-05-20', 3),
(9, '19:30:00', '20:00:00', '2026-05-20', 3),
(10, '20:00:00', '20:30:00', '2026-05-20', 3);

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `visitor_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`visitor_id`, `full_name`, `email`, `phone`, `password`, `created_at`) VALUES
(1, 'Fatima Al-Mohsen', 'fatima@gmail.com', '0501234567', '123456', '2026-04-01 10:00:00'),
(2, 'Sara Al-Qahtani', 'sara@gmail.com', '0505555555', '123456', '2026-04-02 11:00:00'),
(3, 'Norah Al-Shehri', 'norah@gmail.com', '0509876543', '123456', '2026-04-03 09:30:00'),
(4, 'Reema Al-Dosari', 'reema@gmail.com', '0507654321', '123456', '2026-04-04 14:00:00'),
(5, 'Khalid Al-Harbi', 'khalid@gmail.com', '0501111111', '123456', '2026-04-05 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `visitorassignment`
--

CREATE TABLE `visitorassignment` (
  `assignment_id` int(11) NOT NULL,
  `pickup_point` varchar(100) DEFAULT NULL,
  `arrival_time` time DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `guidance_instructions` text,
  `ticket_id` int(11) NOT NULL,
  `gate_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `timeslot_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visitorassignment`
--

INSERT INTO `visitorassignment` (`assignment_id`, `pickup_point`, `arrival_time`, `departure_time`, `guidance_instructions`, `ticket_id`, `gate_id`, `zone_id`, `timeslot_id`) VALUES
(1, 'North Parking - Pickup Point A', '17:00:00', '23:00:00', 'Proceed to Gate A1 via North entrance. Follow the blue signs.', 1, 1, 1, 1),
(2, 'South Parking - Pickup Point B', '17:30:00', '23:00:00', 'Proceed to Gate B1 via South entrance. Follow the red signs.', 2, 4, 2, 2),
(3, 'North Parking - Pickup Point A', '18:00:00', '23:00:00', 'Proceed to Gate A3 via North entrance. Follow the blue signs.', 3, 3, 1, 3),
(4, 'VIP Lounge - Main Entrance', '17:00:00', '23:00:00', 'Proceed directly to VIP Gate. Show your VIP pass at the entrance.', 4, 6, 3, 1),
(5, 'VIP Lounge - Main Entrance', '17:00:00', '23:00:00', 'Proceed directly to VIP Gate. Show your VIP pass at the entrance.', 5, 6, 3, 1),
(6, 'North Parking - Pickup Point C', '09:00:00', '18:00:00', 'Proceed to Gate C1 via North entrance. Follow the green signs.', 6, 7, 4, 5),
(7, 'South Parking - Pickup Point D', '09:30:00', '18:00:00', 'Proceed to Gate D1 via South entrance. Follow the yellow signs.', 7, 9, 5, 6),
(8, 'VIP Lounge - East Wing', '09:00:00', '18:00:00', 'Proceed directly to VIP Gate - East Wing. VIP pass required.', 8, 11, 6, 5),
(9, 'Main Parking - Pickup Point E', '19:00:00', '23:30:00', 'Proceed to Gate E1 via Main entrance. Follow the orange signs.', 9, 12, 7, 8),
(10, 'VIP Lounge - West Wing', '19:00:00', '23:30:00', 'Proceed directly to VIP Gate - West Wing. VIP pass required.', 10, 14, 8, 8);

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `zone_id` int(11) NOT NULL,
  `zone_name` varchar(100) NOT NULL,
  `zone_capacity` int(11) NOT NULL,
  `crowd_level` varchar(50) DEFAULT 'Low',
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `zone`
--

INSERT INTO `zone` (`zone_id`, `zone_name`, `zone_capacity`, `crowd_level`, `event_id`) VALUES
(1, 'North Zone', 1000, 'Moderate', 1),
(2, 'South Zone', 1000, 'High', 1),
(3, 'VIP Zone', 300, 'Low', 1),
(4, 'North Zone', 1500, 'Low', 2),
(5, 'South Zone', 1500, 'Moderate', 2),
(6, 'VIP Zone', 500, 'Low', 2),
(7, 'Main Zone', 2000, 'High', 3),
(8, 'VIP Zone', 400, 'Low', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `assistancerequest`
--
ALTER TABLE `assistancerequest`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `visitor_id` (`visitor_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `eventhistory`
--
ALTER TABLE `eventhistory`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `visitor_id` (`visitor_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- Indexes for table `gate`
--
ALTER TABLE `gate`
  ADD PRIMARY KEY (`gate_id`),
  ADD KEY `zone_id` (`zone_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `visitor_id` (`visitor_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`),
  ADD UNIQUE KEY `ticket_number` (`ticket_number`),
  ADD KEY `visitor_id` (`visitor_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `timeslot`
--
ALTER TABLE `timeslot`
  ADD PRIMARY KEY (`timeslot_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`visitor_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `visitorassignment`
--
ALTER TABLE `visitorassignment`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `gate_id` (`gate_id`),
  ADD KEY `zone_id` (`zone_id`),
  ADD KEY `timeslot_id` (`timeslot_id`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`zone_id`),
  ADD KEY `event_id` (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assistancerequest`
--
ALTER TABLE `assistancerequest`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `eventhistory`
--
ALTER TABLE `eventhistory`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gate`
--
ALTER TABLE `gate`
  MODIFY `gate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `timeslot`
--
ALTER TABLE `timeslot`
  MODIFY `timeslot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `visitor`
--
ALTER TABLE `visitor`
  MODIFY `visitor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `visitorassignment`
--
ALTER TABLE `visitorassignment`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `zone_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assistancerequest`
--
ALTER TABLE `assistancerequest`
  ADD CONSTRAINT `assistancerequest_ibfk_1` FOREIGN KEY (`visitor_id`) REFERENCES `visitor` (`visitor_id`),
  ADD CONSTRAINT `assistancerequest_ibfk_2` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`ticket_id`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `eventhistory`
--
ALTER TABLE `eventhistory`
  ADD CONSTRAINT `eventhistory_ibfk_1` FOREIGN KEY (`visitor_id`) REFERENCES `visitor` (`visitor_id`),
  ADD CONSTRAINT `eventhistory_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`),
  ADD CONSTRAINT `eventhistory_ibfk_3` FOREIGN KEY (`assignment_id`) REFERENCES `visitorassignment` (`assignment_id`);

--
-- Constraints for table `gate`
--
ALTER TABLE `gate`
  ADD CONSTRAINT `gate_ibfk_1` FOREIGN KEY (`zone_id`) REFERENCES `zone` (`zone_id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`visitor_id`) REFERENCES `visitor` (`visitor_id`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`visitor_id`) REFERENCES `visitor` (`visitor_id`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`);

--
-- Constraints for table `timeslot`
--
ALTER TABLE `timeslot`
  ADD CONSTRAINT `timeslot_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`);

--
-- Constraints for table `visitorassignment`
--
ALTER TABLE `visitorassignment`
  ADD CONSTRAINT `visitorassignment_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`ticket_id`),
  ADD CONSTRAINT `visitorassignment_ibfk_2` FOREIGN KEY (`gate_id`) REFERENCES `gate` (`gate_id`),
  ADD CONSTRAINT `visitorassignment_ibfk_3` FOREIGN KEY (`zone_id`) REFERENCES `zone` (`zone_id`),
  ADD CONSTRAINT `visitorassignment_ibfk_4` FOREIGN KEY (`timeslot_id`) REFERENCES `timeslot` (`timeslot_id`);

--
-- Constraints for table `zone`
--
ALTER TABLE `zone`
  ADD CONSTRAINT `zone_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
