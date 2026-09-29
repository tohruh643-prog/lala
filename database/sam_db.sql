-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2026 at 09:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sam_db`
--

CREATE DATABASE IF NOT EXISTS `sam_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sam_db`;

-- --------------------------------------------------------

--
-- Table structure for table `alumni_details`
--

DROP TABLE IF EXISTS `alumni_details`;
CREATE TABLE `alumni_details` (
  `AlumniID` int(11) NOT NULL,
  `InstitutionName` varchar(255) NOT NULL,
  `Degree` varchar(100) NOT NULL,
  `FieldOfStudy` varchar(100) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `S_ID` int(11) DEFAULT NULL,
  `AddedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni_details`
--

INSERT INTO `alumni_details` (`AlumniID`, `InstitutionName`, `Degree`, `FieldOfStudy`, `StartDate`, `EndDate`, `logo`, `description`, `S_ID`, `AddedBy`) VALUES
(6, 'PIES DIGITAL', 'MIT', 'SYSTEM DEVELOPMENT', '2024-06-26', '2024-06-25', 'image/csr-scc.png', 'Avtech Solution', 1, 1),
(7, 'SAM SOLUTIONS', 'BSED-MATH', 'Research', '1988-09-23', '2024-06-25', 'image/ejb.png', 'Research is defined as the creation of new knowledge and/or the use of existing knowledge in a new and creative way so as to generate new concepts, methodologies and understandings. This could include synthesis and analysis of previous research to the extent that it leads to new and creative outcomes.', 5, 1),
(8, 'Diocese of San Carlos', 'DOSC', 'Church System', '2022-01-01', '2024-06-25', 'image/1.png', 'Smart Diocese App', 6, 1),
(10, 'Tanon State', 'MIT', 'Church System', '2025-01-30', '2025-01-16', 'image/Teacher-male512_44209.png', 'pataka', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcourses`
--

DROP TABLE IF EXISTS `tblcourses`;
CREATE TABLE `tblcourses` (
  `COURSE_ID` int(11) NOT NULL,
  `COURSE_CODE` varchar(20) NOT NULL,
  `COURSE_NAME` varchar(150) NOT NULL,
  `COURSE_DESC` text DEFAULT NULL,
  `STATUS` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblcourses`
--

INSERT INTO `tblcourses` (`COURSE_ID`, `COURSE_CODE`, `COURSE_NAME`, `COURSE_DESC`, `STATUS`) VALUES
(1, 'BSIT', 'Bachelor of Science in Information Technology', 'Information Technology program', 'Active'),
(2, 'BSTM', 'Bachelor of Science in Tourism Management', 'Tourism Management program', 'Active'),
(3, 'BSED', 'Bachelor of Secondary Education', 'Secondary Education program', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tblenrollment`
--

DROP TABLE IF EXISTS `tblenrollment`;
CREATE TABLE `tblenrollment` (
  `ENROLLMENT_ID` int(11) NOT NULL,
  `S_ID` int(11) NOT NULL,
  `COURSE_ID` int(11) NOT NULL,
  `SECTION_ID` int(11) DEFAULT NULL,
  `SY_ID` int(11) NOT NULL,
  `YEAR_LEVEL` varchar(20) NOT NULL,
  `SEMESTER` varchar(20) NOT NULL,
  `CATEGORY` varchar(30) NOT NULL DEFAULT 'New',
  `CURRICULUM_YR` varchar(20) DEFAULT NULL,
  `DATE_RESERVED` date DEFAULT NULL,
  `DATE_ENROLLED` date DEFAULT NULL,
  `STATUS` varchar(30) NOT NULL DEFAULT 'Reserved',
  `ENCODED_BY` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblenrollment`
--

INSERT INTO `tblenrollment` (`ENROLLMENT_ID`, `S_ID`, `COURSE_ID`, `SECTION_ID`, `SY_ID`, `YEAR_LEVEL`, `SEMESTER`, `CATEGORY`, `CURRICULUM_YR`, `DATE_RESERVED`, `DATE_ENROLLED`, `STATUS`, `ENCODED_BY`) VALUES
(1, 1, 1, 1, 1, '1st Year', '1st Semester', 'New', '2025-2026', '2025-06-05', '2025-06-10', 'Enrolled', 1),
(2, 5, 1, 2, 1, '1st Year', '1st Semester', 'Old', '2025-2026', '2025-06-06', '2025-06-11', 'Enrolled', 1),
(3, 6, 2, NULL, 1, '1st Year', '1st Semester', 'Transferee', '2025-2026', '2025-06-12', NULL, 'Reserved', 1),
(4, 7, 1, NULL, 1, '4th Year', '2nd Semester', 'Transferee', '2025-2026', '2026-08-24', NULL, 'Reserved', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblenrollment_details`
--

DROP TABLE IF EXISTS `tblenrollment_details`;
CREATE TABLE `tblenrollment_details` (
  `DETAIL_ID` int(11) NOT NULL,
  `ENROLLMENT_ID` int(11) NOT NULL,
  `SUBJECT_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblenrollment_details`
--

INSERT INTO `tblenrollment_details` (`DETAIL_ID`, `ENROLLMENT_ID`, `SUBJECT_ID`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 1),
(5, 2, 2),
(6, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tblgrades`
--

DROP TABLE IF EXISTS `tblgrades`;
CREATE TABLE `tblgrades` (
  `GRADE_ID` int(11) NOT NULL,
  `S_ID` int(11) NOT NULL,
  `SUBJECT_ID` int(11) NOT NULL,
  `ENROLLMENT_ID` int(11) NOT NULL,
  `SY_ID` int(11) NOT NULL,
  `SEMESTER` varchar(20) DEFAULT NULL,
  `GRADE` decimal(5,2) DEFAULT NULL,
  `REMARKS` varchar(20) DEFAULT NULL,
  `DATE_ENCODED` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblgrades`
--

INSERT INTO `tblgrades` (`GRADE_ID`, `S_ID`, `SUBJECT_ID`, `ENROLLMENT_ID`, `SY_ID`, `SEMESTER`, `GRADE`, `REMARKS`, `DATE_ENCODED`) VALUES
(1, 1, 1, 1, 1, '1st Semester', 1.75, 'Passed', '2025-10-20'),
(2, 1, 2, 1, 1, '1st Semester', 2.00, 'Passed', '2025-10-20'),
(3, 1, 3, 1, 1, '1st Semester', 1.50, 'Passed', '2025-10-20'),
(4, 5, 1, 2, 1, '1st Semester', 2.25, 'Passed', '2025-10-20'),
(5, 5, 2, 2, 1, '1st Semester', 3.00, 'Passed', '2025-10-20'),
(6, 5, 3, 2, 1, '1st Semester', 1.25, 'Passed', '2025-10-20');

-- --------------------------------------------------------

--
-- Table structure for table `tblschoolyear`
--

DROP TABLE IF EXISTS `tblschoolyear`;
CREATE TABLE `tblschoolyear` (
  `SY_ID` int(11) NOT NULL,
  `SCHOOL_YEAR` varchar(20) NOT NULL,
  `STATUS` varchar(20) NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblschoolyear`
--

INSERT INTO `tblschoolyear` (`SY_ID`, `SCHOOL_YEAR`, `STATUS`) VALUES
(1, '2025-2026', 'Active'),
(4, '2024-2025', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `tblsections`
--

DROP TABLE IF EXISTS `tblsections`;
CREATE TABLE `tblsections` (
  `SECTION_ID` int(11) NOT NULL,
  `SECTION_NAME` varchar(50) NOT NULL,
  `COURSE_ID` int(11) NOT NULL,
  `SY_ID` int(11) NOT NULL,
  `YEAR_LEVEL` varchar(20) NOT NULL,
  `PROGRAM_HEAD` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblsections`
--

INSERT INTO `tblsections` (`SECTION_ID`, `SECTION_NAME`, `COURSE_ID`, `SY_ID`, `YEAR_LEVEL`, `PROGRAM_HEAD`) VALUES
(1, 'A', 1, 1, '1st Year', NULL),
(2, 'B', 1, 1, '1st Year', NULL),
(3, 'C', 1, 1, '1st Year', NULL),
(4, 'D', 1, 1, '1st Year', NULL),
(5, 'A', 2, 1, '1st Year', NULL),
(6, 'B', 2, 1, '1st Year', NULL),
(7, 'C', 2, 1, '1st Year', NULL),
(8, 'D', 2, 1, '1st Year', NULL),
(9, 'A', 3, 1, '1st Year', NULL),
(10, 'B', 3, 1, '1st Year', NULL),
(11, 'C', 3, 1, '1st Year', NULL),
(12, 'D', 3, 1, '1st Year', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent`
--

DROP TABLE IF EXISTS `tblstudent`;
CREATE TABLE `tblstudent` (
  `S_ID` int(11) NOT NULL,
  `IDNO` varchar(20) NOT NULL,
  `FNAME` varchar(40) NOT NULL,
  `LNAME` varchar(40) NOT NULL,
  `MNAME` varchar(40) NOT NULL,
  `SEX` varchar(10) NOT NULL DEFAULT 'Male',
  `BDAY` date DEFAULT NULL,
  `BPLACE` text DEFAULT NULL,
  `PHOTO` varchar(255) DEFAULT NULL,
  `STATUS` varchar(30) NOT NULL DEFAULT 'Active',
  `AGE` int(11) DEFAULT NULL,
  `NATIONALITY` varchar(40) DEFAULT NULL,
  `RELIGION` varchar(255) DEFAULT NULL,
  `CONTACT_NO` varchar(40) DEFAULT NULL,
  `HOME_ADD` text DEFAULT NULL,
  `EMAIL` varchar(150) DEFAULT NULL,
  `ACC_PASSWORD` text DEFAULT NULL,
  `LRNNO` varchar(15) DEFAULT NULL,
  `CONTACTPERSON` varchar(150) DEFAULT NULL,
  `COMPANYIDNO` int(11) DEFAULT NULL,
  `COURSE_ID` int(11) DEFAULT NULL,
  `AddedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`S_ID`, `IDNO`, `FNAME`, `LNAME`, `MNAME`, `SEX`, `BDAY`, `BPLACE`, `PHOTO`, `STATUS`, `AGE`, `NATIONALITY`, `RELIGION`, `CONTACT_NO`, `HOME_ADD`, `EMAIL`, `ACC_PASSWORD`, `LRNNO`, `CONTACTPERSON`, `COMPANYIDNO`, `COURSE_ID`, `AddedBy`) VALUES
(1, '2011072501', 'ZHA KEISHA', 'BATUTO', 'JIMENEZ', 'Female', '2011-07-25', 'Not on file', NULL, 'Active', 13, 'Not on file', 'Not on file', '09176374293', 'Not on file', 'Not on file', NULL, NULL, NULL, NULL, 1, 1),
(5, '3333', 'Jha Syl', 'hjh', 'hjh', 'Male', '2025-01-14', 'Cebu Cebu', NULL, 'Active', 11, 'Filipino', 'Not on file', 'Not on file', 'Not on file', 'jason@co.ph', NULL, NULL, NULL, NULL, 1, 1),
(6, '22222', 'ssd', 'sds', 'sds', 'Male', '2025-02-04', 'sds', NULL, 'Active', 22, 'Filipino', 'Not on file', 'Not on file', 'Not on file', 'jason@co.ph', NULL, NULL, NULL, NULL, 2, 1),
(7, '534535', 'gfdgdfg', 'gdfgdfg', 'fgdgfd', 'Female', '2007-03-03', 'Not on file', 'S_7.png', 'Active', NULL, 'Not on file', 'Not on file', 'Not on file', 'Not on file', 'Not on file', NULL, NULL, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblsubjects`
--

DROP TABLE IF EXISTS `tblsubjects`;
CREATE TABLE `tblsubjects` (
  `SUBJECT_ID` int(11) NOT NULL,
  `SUBJECT_CODE` varchar(20) NOT NULL,
  `SUBJECT_NAME` varchar(150) NOT NULL,
  `UNITS` int(11) NOT NULL DEFAULT 3,
  `COURSE_ID` int(11) NOT NULL,
  `YEAR_LEVEL` varchar(20) DEFAULT NULL,
  `SEMESTER` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblsubjects`
--

INSERT INTO `tblsubjects` (`SUBJECT_ID`, `SUBJECT_CODE`, `SUBJECT_NAME`, `UNITS`, `COURSE_ID`, `YEAR_LEVEL`, `SEMESTER`) VALUES
(1, 'IT101', 'Introduction to Computing', 3, 1, '1st Year', '1st Semester'),
(2, 'IT102', 'Computer Programming 1', 3, 1, '1st Year', '1st Semester'),
(3, 'IT103', 'Discrete Mathematics', 3, 1, '1st Year', '1st Semester'),
(4, 'IT104', 'Web Systems and Technologies', 3, 1, '1st Year', '2nd Semester'),
(5, 'TM101', 'Introduction to Tourism', 3, 2, '1st Year', '1st Semester'),
(6, 'TM102', 'Philippine Culture and Tourism Geography', 3, 2, '1st Year', '1st Semester'),
(7, 'TM103', 'Micro Perspective of Tourism', 3, 2, '1st Year', '2nd Semester'),
(8, 'ED101', 'The Teaching Profession', 3, 3, '1st Year', '1st Semester'),
(9, 'ED102', 'Child and Adolescent Development', 3, 3, '1st Year', '1st Semester'),
(10, 'ED103', 'Facilitating Learner-Centered Teaching', 3, 3, '1st Year', '2nd Semester');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

DROP TABLE IF EXISTS `tblusers`;
CREATE TABLE `tblusers` (
  `UID` int(11) NOT NULL,
  `DISPLAYNAME` varchar(30) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` text NOT NULL,
  `TYPE` varchar(15) NOT NULL,
  `TYPEID` int(11) DEFAULT NULL,
  `ADDEDBY` int(3) NOT NULL,
  `DATEADDED` date NOT NULL,
  `MODIFIEDBY` int(3) NOT NULL,
  `DATEMODIFIED` date NOT NULL,
  `STATUSACTIVE` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`UID`, `DISPLAYNAME`, `USERNAME`, `PASSWORD`, `TYPE`, `TYPEID`, `ADDEDBY`, `DATEADDED`, `MODIFIEDBY`, `DATEMODIFIED`, `STATUSACTIVE`) VALUES
(1, 'Jason', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrator', 1, 1, '2020-08-27', 1, '2021-07-05', 1),
(77, 'dfd', 'dfd', '6bb65257fcab4e2975cd96b0f7fc4b53d97c10b6', 'Staff', 3, 1, '2025-01-16', 1, '2026-08-02', 1),
(78, 'dfd', 'dfdf', '6bb65257fcab4e2975cd96b0f7fc4b53d97c10b6', 'Staff', 3, 1, '2025-01-16', 1, '2025-01-16', 1),
(79, 'Erick', 'jason', '5c2dd944dde9e08881bef0894fe7b22a5c9c4b06', 'Administrator', 1, 1, '2025-01-24', 1, '2025-01-24', 1),
(81, 'Sam', 'sam', 'f16bed56189e249fe4ca8ed10a1ecae60e8ceac0', 'Administrator', 1, 1, '2026-08-18', 1, '2026-08-18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblusertype`
--

DROP TABLE IF EXISTS `tblusertype`;
CREATE TABLE `tblusertype` (
  `TYPEID` int(11) NOT NULL,
  `USERTYPE` varchar(30) NOT NULL,
  `STATUS` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblusertype`
--

INSERT INTO `tblusertype` (`TYPEID`, `USERTYPE`, `STATUS`) VALUES
(1, 'Administrator', 'Active'),
(2, 'Doctor', 'Active'),
(3, 'Staff', 'Active'),
(7, 'Nurse', 'Active'),
(12, 'hello', 'Inactive'),
(13, 'cashier', 'Active'),
(14, 'sdsds', 'Inactive');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni_details`
--
ALTER TABLE `alumni_details`
  ADD PRIMARY KEY (`AlumniID`),
  ADD KEY `fk_alumni_student` (`S_ID`),
  ADD KEY `fk_alumni_addedby` (`AddedBy`);

--
-- Indexes for table `tblcourses`
--
ALTER TABLE `tblcourses`
  ADD PRIMARY KEY (`COURSE_ID`),
  ADD UNIQUE KEY `COURSE_CODE` (`COURSE_CODE`);

--
-- Indexes for table `tblenrollment`
--
ALTER TABLE `tblenrollment`
  ADD PRIMARY KEY (`ENROLLMENT_ID`),
  ADD UNIQUE KEY `uq_enrollment_term` (`S_ID`,`SY_ID`,`SEMESTER`),
  ADD KEY `fk_enrollment_student` (`S_ID`),
  ADD KEY `fk_enrollment_course` (`COURSE_ID`),
  ADD KEY `fk_enrollment_section` (`SECTION_ID`),
  ADD KEY `fk_enrollment_sy` (`SY_ID`),
  ADD KEY `fk_enrollment_encodedby` (`ENCODED_BY`);

--
-- Indexes for table `tblenrollment_details`
--
ALTER TABLE `tblenrollment_details`
  ADD PRIMARY KEY (`DETAIL_ID`),
  ADD UNIQUE KEY `uq_enrollment_subject` (`ENROLLMENT_ID`,`SUBJECT_ID`),
  ADD KEY `fk_endetails_enrollment` (`ENROLLMENT_ID`),
  ADD KEY `fk_endetails_subject` (`SUBJECT_ID`);

--
-- Indexes for table `tblgrades`
--
ALTER TABLE `tblgrades`
  ADD PRIMARY KEY (`GRADE_ID`),
  ADD KEY `fk_grades_student` (`S_ID`),
  ADD KEY `fk_grades_subject` (`SUBJECT_ID`),
  ADD KEY `fk_grades_enrollment` (`ENROLLMENT_ID`),
  ADD KEY `fk_grades_sy` (`SY_ID`);

--
-- Indexes for table `tblschoolyear`
--
ALTER TABLE `tblschoolyear`
  ADD PRIMARY KEY (`SY_ID`),
  ADD UNIQUE KEY `SCHOOL_YEAR` (`SCHOOL_YEAR`);

--
-- Indexes for table `tblsections`
--
ALTER TABLE `tblsections`
  ADD PRIMARY KEY (`SECTION_ID`),
  ADD KEY `fk_sections_course` (`COURSE_ID`),
  ADD KEY `fk_sections_sy` (`SY_ID`);

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`S_ID`),
  ADD UNIQUE KEY `IDNO` (`IDNO`),
  ADD KEY `fk_student_course` (`COURSE_ID`),
  ADD KEY `fk_student_addedby` (`AddedBy`);

--
-- Indexes for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  ADD PRIMARY KEY (`SUBJECT_ID`),
  ADD UNIQUE KEY `uq_subject_code` (`SUBJECT_CODE`),
  ADD KEY `fk_subjects_course` (`COURSE_ID`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`UID`),
  ADD UNIQUE KEY `uq_username` (`USERNAME`),
  ADD KEY `fk_users_usertype` (`TYPEID`);

--
-- Indexes for table `tblusertype`
--
ALTER TABLE `tblusertype`
  ADD PRIMARY KEY (`TYPEID`),
  ADD UNIQUE KEY `uq_usertype` (`USERTYPE`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumni_details`
--
ALTER TABLE `alumni_details`
  MODIFY `AlumniID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblcourses`
--
ALTER TABLE `tblcourses`
  MODIFY `COURSE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblenrollment`
--
ALTER TABLE `tblenrollment`
  MODIFY `ENROLLMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblenrollment_details`
--
ALTER TABLE `tblenrollment_details`
  MODIFY `DETAIL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblgrades`
--
ALTER TABLE `tblgrades`
  MODIFY `GRADE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblschoolyear`
--
ALTER TABLE `tblschoolyear`
  MODIFY `SY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblsections`
--
ALTER TABLE `tblsections`
  MODIFY `SECTION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `S_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  MODIFY `SUBJECT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `tblusertype`
--
ALTER TABLE `tblusertype`
  MODIFY `TYPEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumni_details`
--
ALTER TABLE `alumni_details`
  ADD CONSTRAINT `fk_alumni_addedby` FOREIGN KEY (`AddedBy`) REFERENCES `tblusers` (`UID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_alumni_student` FOREIGN KEY (`S_ID`) REFERENCES `tblstudent` (`S_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tblenrollment`
--
ALTER TABLE `tblenrollment`
  ADD CONSTRAINT `fk_enrollment_course` FOREIGN KEY (`COURSE_ID`) REFERENCES `tblcourses` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enrollment_encodedby` FOREIGN KEY (`ENCODED_BY`) REFERENCES `tblusers` (`UID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enrollment_section` FOREIGN KEY (`SECTION_ID`) REFERENCES `tblsections` (`SECTION_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enrollment_student` FOREIGN KEY (`S_ID`) REFERENCES `tblstudent` (`S_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enrollment_sy` FOREIGN KEY (`SY_ID`) REFERENCES `tblschoolyear` (`SY_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblenrollment_details`
--
ALTER TABLE `tblenrollment_details`
  ADD CONSTRAINT `fk_endetails_enrollment` FOREIGN KEY (`ENROLLMENT_ID`) REFERENCES `tblenrollment` (`ENROLLMENT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_endetails_subject` FOREIGN KEY (`SUBJECT_ID`) REFERENCES `tblsubjects` (`SUBJECT_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblgrades`
--
ALTER TABLE `tblgrades`
  ADD CONSTRAINT `fk_grades_enrollment` FOREIGN KEY (`ENROLLMENT_ID`) REFERENCES `tblenrollment` (`ENROLLMENT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grades_student` FOREIGN KEY (`S_ID`) REFERENCES `tblstudent` (`S_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grades_subject` FOREIGN KEY (`SUBJECT_ID`) REFERENCES `tblsubjects` (`SUBJECT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grades_sy` FOREIGN KEY (`SY_ID`) REFERENCES `tblschoolyear` (`SY_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblsections`
--
ALTER TABLE `tblsections`
  ADD CONSTRAINT `fk_sections_course` FOREIGN KEY (`COURSE_ID`) REFERENCES `tblcourses` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sections_sy` FOREIGN KEY (`SY_ID`) REFERENCES `tblschoolyear` (`SY_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD CONSTRAINT `fk_student_addedby` FOREIGN KEY (`AddedBy`) REFERENCES `tblusers` (`UID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_course` FOREIGN KEY (`COURSE_ID`) REFERENCES `tblcourses` (`COURSE_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  ADD CONSTRAINT `fk_subjects_course` FOREIGN KEY (`COURSE_ID`) REFERENCES `tblcourses` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD CONSTRAINT `fk_users_usertype` FOREIGN KEY (`TYPEID`) REFERENCES `tblusertype` (`TYPEID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
