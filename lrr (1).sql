

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lrr`
--

-- Table structure for table `courses_table`
--

CREATE TABLE `courses_table` (
  `Course_ID` int(11) NOT NULL,
  `Course_Name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Academic_Year` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `Faculty` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `Lecturer_User_ID` int(11) DEFAULT NULL,
  `TA_User_ID` int(11) DEFAULT NULL,
  `Course_Code` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `URL` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `Verify_New_Members` varchar(10) COLLATE utf8mb4_bin NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `courses_table`
--

INSERT INTO `courses_table` (`Course_ID`, `Course_Name`, `Academic_Year`, `Faculty`, `Lecturer_User_ID`, `TA_User_ID`, `Course_Code`, `URL`, `Verify_New_Members`) VALUES
(13, 'ASE', '2019', 'Computing', 21, 0, 'ASE2019', 'ASE20192019', '0');

-- --------------------------------------------------------

--
-- Table structure for table `course_groups_table`
--

CREATE TABLE `course_groups_table` (
  `Course_Group_id` int(11) NOT NULL,
  `Group_Name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `Group_Leader` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `Course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `course_group_members_table`
--

CREATE TABLE `course_group_members_table` (
  `ID` int(11) NOT NULL,
  `Course_Group_id` int(11) DEFAULT NULL,
  `Student_ID` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `Status` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `course_students_table`
--

CREATE TABLE `course_students_table` (
  `Course_ID` int(11) NOT NULL,
  `Student_ID` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `ID` int(11) NOT NULL,
  `Status` varchar(100) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `course_students_table`
--

INSERT INTO `course_students_table` (`Course_ID`, `Student_ID`, `ID`, `Status`) VALUES
(13, '201825800051', 17, 'Joined');

-- --------------------------------------------------------

--
-- Table structure for table `course_ta`
--

CREATE TABLE `course_ta` (
  `Course_ID` int(11) NOT NULL,
  `TA` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `extended_deadlines_table`
--

CREATE TABLE `extended_deadlines_table` (
  `ID` int(11) NOT NULL,
  `Student_ID` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `Lab_Report_ID` int(11) DEFAULT NULL,
  `Extended_Deadline_Date` date DEFAULT NULL,
  `ReasonsForExtension` longtext COLLATE utf8mb4_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `lab_reports_table`
--

CREATE TABLE `lab_reports_table` (
  `Lab_Report_ID` int(11) NOT NULL,
  `Course_ID` int(11) DEFAULT NULL,
  `Posted_Date` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `Deadline` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `Instructions` longtext COLLATE utf8mb4_bin,
  `Title` longtext COLLATE utf8mb4_bin,
  `Attachment_link_1` longtext COLLATE utf8mb4_bin,
  `Attachment_link_2` longtext COLLATE utf8mb4_bin,
  `Attachment_link_3` longtext COLLATE utf8mb4_bin,
  `Attachment_link_4` longtext COLLATE utf8mb4_bin,
  `Marks` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `Type` varchar(30) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `lab_reports_table`
--

INSERT INTO `lab_reports_table` (`Lab_Report_ID`, `Course_ID`, `Posted_Date`, `Deadline`, `Instructions`, `Title`, `Attachment_link_1`, `Attachment_link_2`, `Attachment_link_3`, `Attachment_link_4`, `Marks`, `Type`) VALUES
(4, 13, '2019-03-19 21:36', '2019-03-19 22:10', 'Lab1 Ass', 'Lab1', '', '', '', '', '10', 'Individual');

-- --------------------------------------------------------

--
-- Table structure for table `lab_report_submissions`
--

CREATE TABLE `lab_report_submissions` (
  `Submission_ID` int(11) NOT NULL,
  `Submission_Date` datetime DEFAULT NULL,
  `Lab_Report_ID` int(11) DEFAULT NULL,
  `Student_id` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `Course_Group_id` int(11) DEFAULT NULL,
  `Attachment1` longtext COLLATE utf8mb4_bin,
  `Notes` longtext COLLATE utf8mb4_bin,
  `Attachment2` varchar(1000) COLLATE utf8mb4_bin NOT NULL,
  `Attachment3` varchar(1000) COLLATE utf8mb4_bin NOT NULL,
  `Attachment4` varchar(1000) COLLATE utf8mb4_bin NOT NULL,
  `Marks` double DEFAULT NULL,
  `Status` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `Title` varchar(500) COLLATE utf8mb4_bin NOT NULL,
  `Visibility` varchar(30) COLLATE utf8mb4_bin NOT NULL DEFAULT 'Private'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `lab_report_submissions`
--

INSERT INTO `lab_report_submissions` (`Submission_ID`, `Submission_Date`, `Lab_Report_ID`, `Student_id`, `Course_Group_id`, `Attachment1`, `Notes`, `Attachment2`, `Attachment3`, `Attachment4`, `Marks`, `Status`, `Title`, `Visibility`) VALUES
(10, '2019-03-19 21:37:00', 4, '201825800051', 0, 'logo.png', '@2019-03-19 21:38 : Good Bro@2019-03-19 21:42 : Ok wan arkay note kaaga danbe', '', '', '', 9, 'Marked', 'Lab1 Submission', 'Private');

-- --------------------------------------------------------

--
-- Table structure for table `students_data`
--

CREATE TABLE `students_data` (
  `ID` int(11) NOT NULL,
  `Student_ID` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `Passport_Number` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `users_table`
--

CREATE TABLE `users_table` (
  `User_ID` int(11) NOT NULL,
  `Email` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `Password` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `Full_Name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `UserType` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `Student_ID` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `Passport_Number` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `Status` varchar(30) COLLATE utf8mb4_bin NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `users_table`
--

INSERT INTO `users_table` (`User_ID`, `Email`, `Password`, `Full_Name`, `UserType`, `Student_ID`, `Passport_Number`, `Status`) VALUES
(15, 'admin@qq.com', 'admin@123', 'System Admin', 'Admin', NULL, NULL, 'Active'),
(20, 'ahamednor@qq.com', 'm@123', 'Ahmed Nor', 'Student', '201825800051', 'P00581930', 'Active'),
(21, 'lanhui@qq.com', '1234', 'Lanhui', 'Lecturer', NULL, '1234', 'Active'),
(22, 'engmohamednor@gmail.com', '123', 'Ta1', 'TA', NULL, '123', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses_table`
--
ALTER TABLE `courses_table`
  ADD PRIMARY KEY (`Course_ID`);

--
-- Indexes for table `course_groups_table`
--
ALTER TABLE `course_groups_table`
  ADD PRIMARY KEY (`Course_Group_id`),
  ADD UNIQUE KEY `Group_Name` (`Group_Name`);

--
-- Indexes for table `course_group_members_table`
--
ALTER TABLE `course_group_members_table`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `course_students_table`
--
ALTER TABLE `course_students_table`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `extended_deadlines_table`
--
ALTER TABLE `extended_deadlines_table`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `lab_reports_table`
--
ALTER TABLE `lab_reports_table`
  ADD PRIMARY KEY (`Lab_Report_ID`);

--
-- Indexes for table `lab_report_submissions`
--
ALTER TABLE `lab_report_submissions`
  ADD PRIMARY KEY (`Submission_ID`);

--
-- Indexes for table `students_data`
--
ALTER TABLE `students_data`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users_table`
--
ALTER TABLE `users_table`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses_table`
--
ALTER TABLE `courses_table`
  MODIFY `Course_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `course_groups_table`
--
ALTER TABLE `course_groups_table`
  MODIFY `Course_Group_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course_group_members_table`
--
ALTER TABLE `course_group_members_table`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course_students_table`
--
ALTER TABLE `course_students_table`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `extended_deadlines_table`
--
ALTER TABLE `extended_deadlines_table`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lab_reports_table`
--
ALTER TABLE `lab_reports_table`
  MODIFY `Lab_Report_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `lab_report_submissions`
--
ALTER TABLE `lab_report_submissions`
  MODIFY `Submission_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `students_data`
--
ALTER TABLE `students_data`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_table`
--
ALTER TABLE `users_table`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
