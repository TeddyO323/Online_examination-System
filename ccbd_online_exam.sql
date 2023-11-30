-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2023 at 10:54 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ccbd_online_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_acc`
--

CREATE TABLE `admin_acc` (
  `admin_id` int(11) NOT NULL,
  `admin_user` varchar(1000) NOT NULL,
  `admin_pass` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_acc`
--

INSERT INTO `admin_acc` (`admin_id`, `admin_user`, `admin_pass`) VALUES
(1, 'ccbd', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `course_tbl`
--

CREATE TABLE `course_tbl` (
  `cou_id` int(11) NOT NULL,
  `course_name` varchar(1000) NOT NULL,
  `course_description` varchar(1000) NOT NULL,
  `course_code` int(100) NOT NULL,
  `course_category` varchar(255) NOT NULL,
  `course_instructor` varchar(1000) NOT NULL,
  `course_materials` varchar(1000) NOT NULL,
  `course_prerequisites` varchar(1000) NOT NULL,
  `course_fees` int(100) NOT NULL,
  `cou_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `course_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_tbl`
--

INSERT INTO `course_tbl` (`cou_id`, `course_name`, `course_description`, `course_code`, `course_category`, `course_instructor`, `course_materials`, `course_prerequisites`, `course_fees`, `cou_created`, `course_level`) VALUES
(20, 'Information Technology', 'This ntroductory course in Information Technology provides students with a comprehensive understanding of the fundamental concepts, principles, and applications within the field. The course aims to equip students with the necessary knowledge and skills to navigate the dynamic landscape of information technology, fostering a solid foundation for further specialization.', 333, '', '', 'none', 'none', 0, '2023-11-30 20:55:58', ''),
(21, 'Software Engineering', 'This introductory engineering course provides students with a comprehensive understanding of the fundamental principles, methodologies, and applications within the field of engineering. The course is designed to lay the groundwork for further specialization in various engineering disciplines, fostering a solid foundation for academic and professional pursuits.', 1234, '', '', 'none', 'none', 0, '2023-11-30 20:47:36', 'bachelors');

-- --------------------------------------------------------

--
-- Table structure for table `examinee_tbl`
--

CREATE TABLE `examinee_tbl` (
  `exmne_id` int(11) NOT NULL,
  `exmne_fullname` varchar(1000) NOT NULL,
  `exmne_course` varchar(1000) NOT NULL,
  `exmne_gender` varchar(1000) NOT NULL,
  `exmne_birthdate` varchar(1000) NOT NULL,
  `reg_no` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `exmne_year_level` varchar(1000) NOT NULL,
  `exmne_email` varchar(1000) NOT NULL,
  `exmne_password` varchar(1000) NOT NULL,
  `exmne_status` varchar(1000) NOT NULL DEFAULT 'active',
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `examinee_tbl`
--

INSERT INTO `examinee_tbl` (`exmne_id`, `exmne_fullname`, `exmne_course`, `exmne_gender`, `exmne_birthdate`, `reg_no`, `address`, `contact_no`, `exmne_year_level`, `exmne_email`, `exmne_password`, `exmne_status`, `last_login`) VALUES
(18, 'Teddy Omondi', 'Software Engineering', 'male', '1997-08-07', 'BSCIT-01/0223/2022', 'Ushirika Road, Langata, Langata, Nairobi, Kenya.', '+254718125831', '', 'teddyomondi@zetech.ac.ke', '12345678', 'active', '2023-11-30 21:47:41');

-- --------------------------------------------------------

--
-- Table structure for table `examiner_tbl`
--

CREATE TABLE `examiner_tbl` (
  `examiner_id` int(11) NOT NULL,
  `examiner_number` varchar(50) DEFAULT NULL,
  `examiner_name` varchar(255) NOT NULL,
  `examiner_email` varchar(255) NOT NULL,
  `examiner_password` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `access_level` int(11) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `joining_date` date NOT NULL,
  `certification` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `examiner_status` varchar(255) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `examiner_tbl`
--

INSERT INTO `examiner_tbl` (`examiner_id`, `examiner_number`, `examiner_name`, `examiner_email`, `examiner_password`, `contact_number`, `address`, `department`, `role`, `access_level`, `specialization`, `date_of_birth`, `joining_date`, `certification`, `notes`, `gender`, `last_login`, `examiner_status`) VALUES
(7, '4444', 'Teddy Omondi', 'teddyomondi@zetech.ac.ke', '12345678', '+254718125831', 'Ushirika Road, Langata, Langata, Nairobi, Kenya.', 'ICT', 'Main lec', 3, 'Ict', '1992-10-22', '2023-11-29', 'BSCIT', 'none', 'male', '2023-11-30 21:24:28', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `exam_answers`
--

CREATE TABLE `exam_answers` (
  `exans_id` int(11) NOT NULL,
  `reg_no` varchar(255) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `exans_answer` varchar(1000) NOT NULL,
  `exans_status` varchar(1000) NOT NULL DEFAULT 'new',
  `exans_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question_type` varchar(255) DEFAULT NULL,
  `examat_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exam_attempt`
--

CREATE TABLE `exam_attempt` (
  `examat_id` int(11) NOT NULL,
  `reg_no` varchar(255) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `time_limit` int(11) DEFAULT NULL,
  `examat_status` varchar(1000) NOT NULL DEFAULT 'used'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exam_attempts_tbl`
--

CREATE TABLE `exam_attempts_tbl` (
  `attempt_id` int(11) NOT NULL,
  `ex_id` int(11) DEFAULT NULL,
  `reg_no` varchar(255) DEFAULT NULL,
  `timestamp_attempt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_attempts_tbl`
--

INSERT INTO `exam_attempts_tbl` (`attempt_id`, `ex_id`, `reg_no`, `timestamp_attempt`) VALUES
(36, 2, '2', '2023-11-27 13:58:00'),
(37, 44, '22', '2023-11-27 14:06:26'),
(38, 22, '11', '2023-11-27 14:06:49'),
(39, 22, '11', '2023-11-27 14:10:17'),
(40, NULL, NULL, '2023-11-27 14:15:09');

-- --------------------------------------------------------

--
-- Table structure for table `exam_grades`
--

CREATE TABLE `exam_grades` (
  `grade_id` int(11) NOT NULL,
  `examiner_id` int(11) DEFAULT NULL,
  `examinee_id` int(11) DEFAULT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `given_answer` text,
  `correct_answer` text,
  `grade` float DEFAULT NULL,
  `grading_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `examat_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_grades`
--

INSERT INTO `exam_grades` (`grade_id`, `examiner_id`, `examinee_id`, `exam_id`, `question_id`, `given_answer`, `correct_answer`, `grade`, `grading_date`, `examat_id`) VALUES
(211, 4423, 15, 33, 196, NULL, NULL, 11, '2023-11-20 15:31:10', 90),
(212, 4423, 15, 33, 194, '', 'It will work one day', 4, '2023-11-20 15:31:10', 90),
(213, 4423, 15, 33, 197, '', 'Teddy Omondi', 2, '2023-11-20 15:31:10', 90),
(214, 4423, 15, 33, 196, NULL, NULL, 23, '2023-11-20 15:40:43', 91),
(215, 4423, 15, 33, 194, '', 'It will work one day', 4, '2023-11-20 15:40:43', 91),
(216, 4423, 15, 33, 197, '', 'Teddy Omondi', 2, '2023-11-20 15:40:43', 91),
(217, 4423, 15, 33, 196, NULL, NULL, 25, '2023-11-20 16:15:25', 92),
(218, 4423, 15, 33, 194, '', 'It will work one day', 4, '2023-11-20 16:15:25', 92),
(219, 4423, 15, 33, 197, '', 'Teddy Omondi', 2, '2023-11-20 16:15:25', 92),
(220, 1234, 16, 35, 198, '', 'No chance', 2, '2023-11-21 11:23:30', 96),
(221, 4423, 15, 34, 199, '', 'Langata', 2, '2023-11-22 18:09:22', 97),
(222, 4423, 17, 38, 201, '', 'Teddy Omondi', 2, '2023-11-23 17:50:13', 100),
(223, 4423, 15, 44, 203, '', 'Teddy Omondi', 2, '2023-11-24 10:01:04', 101),
(224, 4423, 17, 44, 203, '', 'Teddy Omondi', 2, '2023-11-24 10:46:58', 102),
(225, 4423, 17, 44, 203, '', 'Teddy Omondi', 0, '2023-11-24 10:49:00', 103),
(226, 4423, 16, 44, 203, '', 'Teddy Omondi', 2, '2023-11-24 10:52:44', 104),
(227, 4423, 15, 49, 210, NULL, NULL, 20, '2023-11-29 06:15:15', 146),
(228, 4423, 15, 49, 208, '', 'SDFB', 0, '2023-11-29 06:15:15', 146),
(229, 4423, 15, 49, 209, '', 'I am also hoping it works,It wont work too sir', 0, '2023-11-29 06:15:15', 146),
(230, 4423, 15, 49, 210, NULL, NULL, 10, '2023-11-29 06:48:24', 156),
(231, 4423, 15, 49, 208, '', 'SDFB', 3, '2023-11-29 06:48:24', 156),
(232, 4423, 15, 49, 209, '', 'I am also hoping it works,It wont work too sir', 2, '2023-11-29 06:48:24', 156);

-- --------------------------------------------------------

--
-- Table structure for table `exam_question_tbl`
--

CREATE TABLE `exam_question_tbl` (
  `eqt_id` int(11) NOT NULL,
  `ex_id` int(11) NOT NULL,
  `exam_question` varchar(1000) NOT NULL,
  `exam_ch1` varchar(1000) NOT NULL,
  `exam_ch2` varchar(1000) NOT NULL,
  `exam_ch3` varchar(1000) NOT NULL,
  `exam_ch4` varchar(1000) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `essay_question` varchar(1000) NOT NULL,
  `exam_answer` varchar(1000) NOT NULL,
  `exam_status` varchar(1000) NOT NULL DEFAULT 'active',
  `question_type` varchar(50) DEFAULT NULL,
  `marks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_question_tbl`
--

INSERT INTO `exam_question_tbl` (`eqt_id`, `ex_id`, `exam_question`, `exam_ch1`, `exam_ch2`, `exam_ch3`, `exam_ch4`, `photo`, `essay_question`, `exam_answer`, `exam_status`, `question_type`, `marks`) VALUES
(214, 60, 'essay question', '', '', '', '', 'Screenshot (4).png', '', '', 'active', 'essay', 3),
(215, 60, 'essay question', '', '', '', '', 'Screenshot (4).png', '', '', 'active', 'essay', 3);

-- --------------------------------------------------------

--
-- Table structure for table `exam_tbl`
--

CREATE TABLE `exam_tbl` (
  `ex_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `examiner_number` varchar(50) NOT NULL,
  `examiner_name` varchar(255) NOT NULL,
  `exam_title` varchar(255) NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  `ex_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `exam_time_limit` int(11) DEFAULT NULL,
  `exam_start_datetime` datetime DEFAULT NULL,
  `exam_end_datetime` datetime DEFAULT NULL,
  `exam_description` text,
  `max_leave_attempts` int(11) DEFAULT '3',
  `max_attempts` int(11) DEFAULT '1',
  `attempts_allowed` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_tbl`
--

INSERT INTO `exam_tbl` (`ex_id`, `course_name`, `examiner_number`, `examiner_name`, `exam_title`, `unit_name`, `ex_created`, `exam_time_limit`, `exam_start_datetime`, `exam_end_datetime`, `exam_description`, `max_leave_attempts`, `max_attempts`, `attempts_allowed`) VALUES
(60, 'Software Engineering', '4444', 'Teddy Omondi', 'Advanced Computer Graphics', '', '2023-11-30 21:01:34', 240, '2023-12-08 09:00:00', '2023-12-08 20:00:00', 'cd', 32, 1, 33);

-- --------------------------------------------------------

--
-- Table structure for table `feedback_tbl`
--

CREATE TABLE `feedback_tbl` (
  `feedback_id` int(11) NOT NULL,
  `reg_no` varchar(20) NOT NULL,
  `feedback_category` varchar(50) NOT NULL,
  `feedback_type` varchar(50) NOT NULL,
  `feedback_text` text NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback_tbl`
--

INSERT INTO `feedback_tbl` (`feedback_id`, `reg_no`, `feedback_category`, `feedback_type`, `feedback_text`, `file_name`, `submission_date`) VALUES
(7, 'BSCIT-01/0225/2022', 'Technical Issues', 'Not Anonymous', 'ds', 'nhif.jpg', '2023-11-30 12:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `photo_id` int(11) NOT NULL,
  `ex_id` int(11) NOT NULL,
  `photo_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suspended_examinee_accounts_tbl`
--

CREATE TABLE `suspended_examinee_accounts_tbl` (
  `suspended_id` int(11) NOT NULL,
  `examinee_id` int(11) DEFAULT NULL,
  `user_fullname` varchar(255) DEFAULT NULL,
  `suspension_duration` datetime DEFAULT NULL,
  `suspension_type` varchar(20) DEFAULT NULL,
  `reason_for_suspension` text,
  `date_of_suspension` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suspended_examiner_accounts_tbl`
--

CREATE TABLE `suspended_examiner_accounts_tbl` (
  `suspended_id` int(11) NOT NULL,
  `examiner_id` int(11) DEFAULT NULL,
  `user_fullname` varchar(255) DEFAULT NULL,
  `suspension_duration` datetime DEFAULT NULL,
  `suspension_type` varchar(20) DEFAULT NULL,
  `reason_for_suspension` text,
  `date_of_suspension` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `units_tbl`
--

CREATE TABLE `units_tbl` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  `unit_code` varchar(255) NOT NULL,
  `course_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units_tbl`
--

INSERT INTO `units_tbl` (`unit_id`, `unit_name`, `unit_code`, `course_name`) VALUES
(4, 'Software Engineering', '213', 'Computer Science');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `security_question` varchar(255) NOT NULL,
  `security_answer` varchar(255) NOT NULL,
  `terms_and_conditions` tinyint(4) NOT NULL,
  `privacy_policy` tinyint(4) NOT NULL,
  `newsletter_subscription` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `username`, `date_of_birth`, `gender`, `phone_number`, `address`, `security_question`, `security_answer`, `terms_and_conditions`, `privacy_policy`, `newsletter_subscription`) VALUES
(0, 'Teddy Omondi', 'omosh60@gmail.com', '$2y$10$atUu4YN14LD6DGYLBPMEw.1nFi/0g/9rEw8C3kp207jVQEb3s7oeC', '', '0000-00-00', 'Male', '', '', '', '', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_acc`
--
ALTER TABLE `admin_acc`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `course_tbl`
--
ALTER TABLE `course_tbl`
  ADD PRIMARY KEY (`cou_id`),
  ADD KEY `course_name` (`course_name`(767));

--
-- Indexes for table `examinee_tbl`
--
ALTER TABLE `examinee_tbl`
  ADD PRIMARY KEY (`exmne_id`),
  ADD UNIQUE KEY `unique_reg_no` (`reg_no`);

--
-- Indexes for table `examiner_tbl`
--
ALTER TABLE `examiner_tbl`
  ADD PRIMARY KEY (`examiner_id`),
  ADD UNIQUE KEY `examiner_number` (`examiner_number`);

--
-- Indexes for table `exam_answers`
--
ALTER TABLE `exam_answers`
  ADD PRIMARY KEY (`exans_id`);

--
-- Indexes for table `exam_attempt`
--
ALTER TABLE `exam_attempt`
  ADD PRIMARY KEY (`examat_id`);

--
-- Indexes for table `exam_attempts_tbl`
--
ALTER TABLE `exam_attempts_tbl`
  ADD PRIMARY KEY (`attempt_id`);

--
-- Indexes for table `exam_grades`
--
ALTER TABLE `exam_grades`
  ADD PRIMARY KEY (`grade_id`);

--
-- Indexes for table `exam_question_tbl`
--
ALTER TABLE `exam_question_tbl`
  ADD PRIMARY KEY (`eqt_id`),
  ADD KEY `fk_exam_id` (`ex_id`);

--
-- Indexes for table `exam_tbl`
--
ALTER TABLE `exam_tbl`
  ADD PRIMARY KEY (`ex_id`),
  ADD KEY `ex_id` (`ex_id`);

--
-- Indexes for table `feedback_tbl`
--
ALTER TABLE `feedback_tbl`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `ex_id` (`ex_id`);

--
-- Indexes for table `suspended_examinee_accounts_tbl`
--
ALTER TABLE `suspended_examinee_accounts_tbl`
  ADD PRIMARY KEY (`suspended_id`);

--
-- Indexes for table `suspended_examiner_accounts_tbl`
--
ALTER TABLE `suspended_examiner_accounts_tbl`
  ADD PRIMARY KEY (`suspended_id`);

--
-- Indexes for table `units_tbl`
--
ALTER TABLE `units_tbl`
  ADD PRIMARY KEY (`unit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_acc`
--
ALTER TABLE `admin_acc`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course_tbl`
--
ALTER TABLE `course_tbl`
  MODIFY `cou_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `examinee_tbl`
--
ALTER TABLE `examinee_tbl`
  MODIFY `exmne_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `examiner_tbl`
--
ALTER TABLE `examiner_tbl`
  MODIFY `examiner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exam_answers`
--
ALTER TABLE `exam_answers`
  MODIFY `exans_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `exam_attempt`
--
ALTER TABLE `exam_attempt`
  MODIFY `examat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT for table `exam_attempts_tbl`
--
ALTER TABLE `exam_attempts_tbl`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `exam_grades`
--
ALTER TABLE `exam_grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `exam_question_tbl`
--
ALTER TABLE `exam_question_tbl`
  MODIFY `eqt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT for table `exam_tbl`
--
ALTER TABLE `exam_tbl`
  MODIFY `ex_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `feedback_tbl`
--
ALTER TABLE `feedback_tbl`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suspended_examinee_accounts_tbl`
--
ALTER TABLE `suspended_examinee_accounts_tbl`
  MODIFY `suspended_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `suspended_examiner_accounts_tbl`
--
ALTER TABLE `suspended_examiner_accounts_tbl`
  MODIFY `suspended_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units_tbl`
--
ALTER TABLE `units_tbl`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam_attempts_tbl`
--
ALTER TABLE `exam_attempts_tbl`
  ADD CONSTRAINT `exam_attempts_tbl_ibfk_1` FOREIGN KEY (`ex_id`) REFERENCES `exam_tbl` (`ex_id`),
  ADD CONSTRAINT `exam_attempts_tbl_ibfk_2` FOREIGN KEY (`reg_no`) REFERENCES `examinee_tbl` (`reg_no`);

--
-- Constraints for table `exam_question_tbl`
--
ALTER TABLE `exam_question_tbl`
  ADD CONSTRAINT `fk_exam_id` FOREIGN KEY (`ex_id`) REFERENCES `exam_tbl` (`ex_id`) ON DELETE CASCADE;

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `fk_ex_id` FOREIGN KEY (`ex_id`) REFERENCES `exam_tbl` (`ex_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
