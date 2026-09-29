-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2026 at 03:17 AM
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
-- Database: `alumni_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumni_details`
--

CREATE TABLE `alumni_details` (
  `AlumniID` int(11) NOT NULL,
  `InstitutionName` varchar(255) NOT NULL,
  `Degree` varchar(100) NOT NULL,
  `FieldOfStudy` varchar(100) DEFAULT NULL,
  `StartDate` date DEFAULT current_timestamp(),
  `EndDate` date DEFAULT current_timestamp(),
  `logo` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni_details`
--

INSERT INTO `alumni_details` (`AlumniID`, `InstitutionName`, `Degree`, `FieldOfStudy`, `StartDate`, `EndDate`, `logo`, `description`) VALUES
(6, 'PIES DIGITAL', 'MIT', 'SYSTEM DEVELOPMENT', '2024-06-26', '2024-06-25', 'image/csr-scc.png', 'Avtech Solution'),
(7, 'EJB SOLUTION', 'BSED-MATH', 'Research', '1988-09-23', '2024-06-25', 'image/ejb.png', 'Research is defined as the creation of new knowledge and/or the use of existing knowledge in a new and creative way so as to generate new concepts, methodologies and understandings. This could include synthesis and analysis of previous research to the extent that it leads to new and creative outcomes.'),
(8, 'Diocese of San Carlos', 'DOSC', 'Church System', '2022-01-01', '2024-06-25', 'image/1.png', 'Smart Diocese App'),
(10, 'Tanon State', 'MIT', 'Church System', '2025-01-30', '2025-01-16', 'image/Teacher-male512_44209.png', 'pataka');

-- --------------------------------------------------------

--
-- Table structure for table `tblcourse`
--

CREATE TABLE `tblcourse` (
  `C_ID` int(11) NOT NULL,
  `CourseCode` varchar(50) NOT NULL,
  `CourseName` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcourse`
--

INSERT INTO `tblcourse` (`C_ID`, `CourseCode`, `CourseName`, `created_at`) VALUES
(1, 'BSCS', 'Bachelor of Science in Computer Science', '2026-08-11 15:31:35'),
(2, 'BSIS', 'Bachelor of Science in Information Systems', '2026-08-11 15:31:35'),
(3, 'BSIT', 'Bachelor of Science in Information Technology', '2026-08-11 15:31:35');

-- --------------------------------------------------------

--
-- Table structure for table `tblenrollment`
--

CREATE TABLE `tblenrollment` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `schoolyear_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblenrollment_details`
--

CREATE TABLE `tblenrollment_details` (
  `enrollment_detail_id` int(11) NOT NULL,
  `enrollment_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblgrades`
--

CREATE TABLE `tblgrades` (
  `grade_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `grade` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblschoolyear`
--

CREATE TABLE `tblschoolyear` (
  `schoolyear_id` int(11) NOT NULL,
  `school_year` varchar(20) NOT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblsections`
--

CREATE TABLE `tblsections` (
  `section_id` int(11) NOT NULL,
  `section_name` varchar(100) NOT NULL,
  `schoolyear_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent`
--

CREATE TABLE `tblstudent` (
  `S_ID` int(11) NOT NULL,
  `IDNO` int(20) NOT NULL,
  `FNAME` varchar(40) NOT NULL,
  `LNAME` varchar(40) NOT NULL,
  `MNAME` varchar(40) NOT NULL,
  `SEX` varchar(10) NOT NULL DEFAULT 'Male',
  `BDAY` date NOT NULL DEFAULT current_timestamp(),
  `BPLACE` text NOT NULL,
  `STATUS` varchar(30) NOT NULL,
  `AGE` int(30) NOT NULL,
  `NATIONALITY` varchar(40) NOT NULL,
  `RELIGION` varchar(255) NOT NULL,
  `CONTACT_NO` varchar(40) NOT NULL,
  `HOME_ADD` text NOT NULL,
  `EMAIL` varchar(150) NOT NULL,
  `ACC_PASSWORD` text NOT NULL,
  `LRNNO` varchar(15) NOT NULL,
  `CONTACTPERSON` varchar(150) NOT NULL,
  `COMPANYIDNO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`S_ID`, `IDNO`, `FNAME`, `LNAME`, `MNAME`, `SEX`, `BDAY`, `BPLACE`, `STATUS`, `AGE`, `NATIONALITY`, `RELIGION`, `CONTACT_NO`, `HOME_ADD`, `EMAIL`, `ACC_PASSWORD`, `LRNNO`, `CONTACTPERSON`, `COMPANYIDNO`) VALUES
(1, 2011072501, 'ZHA KEISHA', 'BATUTO', 'JIMENEZ', 'Female', '2011-07-25', '', '', 13, '', '', '09176374293', '', '', '', '', '', 0),
(5, 3333, 'Jha Syl', 'hjh', 'hjh', 'Male', '2025-01-14', 'Cebu Cebu', 'hjhj', 11, 'dfd', 'hjh', 'dfd', 'dfd', 'jason@co.ph', 'hjjh', '', 'hjhjh', 0),
(6, 22222, 'ssd', 'sds', 'sds', 'Select Gen', '2025-02-04', 'sds', 'sds', 222, 'sds', 'df', 'ddfd', 'dfd', 'jason@co.ph', 'dfd', '', '12121', 0),
(8, 4, 'guh', 'mlkj', 'hiy', 'Male', '2007-10-26', '', '', 0, '', '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblsubjects`
--

CREATE TABLE `tblsubjects` (
  `subject_id` int(11) NOT NULL,
  `subject_code` varchar(50) DEFAULT NULL,
  `subject_name` varchar(150) NOT NULL,
  `units` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `UID` int(11) NOT NULL,
  `DISPLAYNAME` varchar(30) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` text NOT NULL,
  `TYPE` varchar(15) NOT NULL,
  `ADDEDBY` int(3) NOT NULL,
  `DATEADDED` date NOT NULL,
  `MODIFIEDBY` int(3) NOT NULL,
  `DATEMODIFIED` date NOT NULL,
  `STATUSACTIVE` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`UID`, `DISPLAYNAME`, `USERNAME`, `PASSWORD`, `TYPE`, `ADDEDBY`, `DATEADDED`, `MODIFIEDBY`, `DATEMODIFIED`, `STATUSACTIVE`) VALUES
(1, 'Jason', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrator', 1, '2020-08-27', 1, '2021-07-05', 1),
(77, 'dfd', 'dfd', '6bb65257fcab4e2975cd96b0f7fc4b53d97c10b6', 'Staff', 1, '2025-01-16', 1, '2025-01-16', 1),
(78, 'dfd', 'dfdf', '6bb65257fcab4e2975cd96b0f7fc4b53d97c10b6', 'Staff', 1, '2025-01-16', 1, '2025-01-16', 1),
(79, 'Erick', 'jason', '5c2dd944dde9e08881bef0894fe7b22a5c9c4b06', 'Administrator', 1, '2025-01-24', 1, '2025-01-24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblusertype`
--

CREATE TABLE `tblusertype` (
  `TYPEID` int(11) NOT NULL,
  `USERTYPE` varchar(30) NOT NULL,
  `STATUS` enum('Active','In-Active') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblusertype`
--

INSERT INTO `tblusertype` (`TYPEID`, `USERTYPE`, `STATUS`) VALUES
(0, 'Administrator', 'Active'),
(2, 'Doctor', 'In-Active'),
(3, 'Staff', 'Active'),
(7, 'Nurse', 'In-Active'),
(11, 'wwewew', 'Active'),
(12, 'Administrator', 'In-Active'),
(13, 'cashier', 'Active'),
(14, 'sdsds', 'In-Active'),
(15, 'aw', 'Active'),
(16, 'awaw', 'In-Active'),
(17, 'awawaw', 'In-Active'),
(18, 'Bruce Lee', 'Active'),
(19, 'delfin', 'Active'),
(20, 'hgchty', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni_details`
--
ALTER TABLE `alumni_details`
  ADD PRIMARY KEY (`AlumniID`);

--
-- Indexes for table `tblcourse`
--
ALTER TABLE `tblcourse`
  ADD PRIMARY KEY (`C_ID`),
  ADD UNIQUE KEY `CourseCode` (`CourseCode`);

--
-- Indexes for table `tblenrollment`
--
ALTER TABLE `tblenrollment`
  ADD PRIMARY KEY (`enrollment_id`);

--
-- Indexes for table `tblenrollment_details`
--
ALTER TABLE `tblenrollment_details`
  ADD PRIMARY KEY (`enrollment_detail_id`);

--
-- Indexes for table `tblgrades`
--
ALTER TABLE `tblgrades`
  ADD PRIMARY KEY (`grade_id`);

--
-- Indexes for table `tblschoolyear`
--
ALTER TABLE `tblschoolyear`
  ADD PRIMARY KEY (`schoolyear_id`);

--
-- Indexes for table `tblsections`
--
ALTER TABLE `tblsections`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`S_ID`),
  ADD UNIQUE KEY `IDNO` (`IDNO`);

--
-- Indexes for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`UID`);

--
-- Indexes for table `tblusertype`
--
ALTER TABLE `tblusertype`
  ADD PRIMARY KEY (`TYPEID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumni_details`
--
ALTER TABLE `alumni_details`
  MODIFY `AlumniID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblcourse`
--
ALTER TABLE `tblcourse`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblenrollment`
--
ALTER TABLE `tblenrollment`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblenrollment_details`
--
ALTER TABLE `tblenrollment_details`
  MODIFY `enrollment_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblgrades`
--
ALTER TABLE `tblgrades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblschoolyear`
--
ALTER TABLE `tblschoolyear`
  MODIFY `schoolyear_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblsections`
--
ALTER TABLE `tblsections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `S_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `tblusertype`
--
ALTER TABLE `tblusertype`
  MODIFY `TYPEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
