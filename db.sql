-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.35-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for dbmmis
DROP DATABASE IF EXISTS `dbmmis`;
CREATE DATABASE IF NOT EXISTS `dbmmis` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dbmmis`;

-- Dumping structure for view dbmmis.credentialview
DROP VIEW IF EXISTS `credentialview`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `credentialview` (
	`ID` INT(11) NOT NULL,
	`name` VARCHAR(101) NOT NULL COLLATE 'utf8_general_ci',
	`url` VARCHAR(150) NULL COLLATE 'utf8_general_ci',
	`userID` VARCHAR(150) NULL COLLATE 'utf8_general_ci',
	`password` VARCHAR(150) NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view dbmmis.memberview
DROP VIEW IF EXISTS `memberview`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `memberview` (
	`ID` INT(11) NOT NULL,
	`fname` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`mname` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`lname` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`dob` DATE NOT NULL,
	`pob` TEXT NOT NULL COLLATE 'utf8_general_ci',
	`age` TINYINT(4) NOT NULL,
	`sex` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`civil_status` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`edu_attainment` VARCHAR(150) NOT NULL COLLATE 'utf8_general_ci',
	`occupation` VARCHAR(150) NOT NULL COLLATE 'utf8_general_ci',
	`income` DECIMAL(10,0) NOT NULL,
	`skills` TEXT NOT NULL COLLATE 'utf8_general_ci',
	`imgurl` VARCHAR(150) NULL COLLATE 'utf8_general_ci',
	`status` VARCHAR(50) NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for table dbmmis.tblcomposition
DROP TABLE IF EXISTS `tblcomposition`;
CREATE TABLE IF NOT EXISTS `tblcomposition` (
  `ID` int(11) DEFAULT NULL,
  `name` text NOT NULL,
  `relationship` varchar(150) NOT NULL,
  `c_age` tinyint(4) NOT NULL,
  `c_civil_status` varchar(50) NOT NULL,
  `c_occupation` varchar(150) NOT NULL,
  `c_income` decimal(10,0) NOT NULL,
  KEY `ID` (`ID`),
  CONSTRAINT `FK_tblcomposition_tblmember` FOREIGN KEY (`ID`) REFERENCES `tblmember` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table dbmmis.tblcomposition: ~2 rows (approximately)
/*!40000 ALTER TABLE `tblcomposition` DISABLE KEYS */;
INSERT INTO `tblcomposition` (`ID`, `name`, `relationship`, `c_age`, `c_civil_status`, `c_occupation`, `c_income`) VALUES
	(54, 'Karla Avecilla', 'Daughter', 26, 'SIngle', 'None', 0),
	(54, 'Azazel Alqueza', 'Daughter', 8, 'Single', 'None', 0);
/*!40000 ALTER TABLE `tblcomposition` ENABLE KEYS */;

-- Dumping structure for table dbmmis.tblmember
DROP TABLE IF EXISTS `tblmember`;
CREATE TABLE IF NOT EXISTS `tblmember` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `pob` text NOT NULL,
  `age` tinyint(4) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `civil_status` varchar(10) NOT NULL,
  `edu_attainment` varchar(150) NOT NULL,
  `occupation` varchar(150) NOT NULL,
  `income` decimal(10,0) NOT NULL,
  `skills` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- Dumping data for table dbmmis.tblmember: ~4 rows (approximately)
/*!40000 ALTER TABLE `tblmember` DISABLE KEYS */;
INSERT INTO `tblmember` (`ID`, `fname`, `mname`, `lname`, `dob`, `pob`, `age`, `sex`, `civil_status`, `edu_attainment`, `occupation`, `income`, `skills`, `date_created`) VALUES
	(54, 'Jan Maverick', 'Ordoña', 'Alqueza', '0000-00-00', 'Ramon Magsaysay Memorial Hospital', 60, 'male', 'Single', 'College Graduate', 'Web Developer', 15000, 'Carpenter', '2019-02-21 18:43:04'),
	(55, 'asda', 'sad', 'sadsad', '0000-00-00', 'RMTU', 60, 'male', 'Single', 'High School Graduate', 'sdada', 0, 'Carpenter', '2019-02-21 18:45:07'),
	(56, 'asdad', 'asdas', 'asdasd', '0000-00-00', 'adsad', 60, 'male', 'Single', 'Elementary Graduate', 'asdasd', 3, 'asd', '2019-02-21 19:06:40'),
	(57, 'asdad', 'asdas', 'asdasd', '0000-00-00', 'adsad', 60, 'male', 'Single', 'Elementary Graduate', 'asdasd', 3, 'asd', '2019-02-21 19:10:00'),
	(58, 'asdsadasdas', 'asdad', 'asdasd', '0000-00-00', 'Ramon Magsaysay Memorial Hospital', 60, 'male', 'Single', 'Elementary Graduate', 'Web Developer', 1, 'asdsd', '2019-02-21 19:10:14');
/*!40000 ALTER TABLE `tblmember` ENABLE KEYS */;

-- Dumping structure for table dbmmis.tblmembercredentials
DROP TABLE IF EXISTS `tblmembercredentials`;
CREATE TABLE IF NOT EXISTS `tblmembercredentials` (
  `ID` int(11) NOT NULL,
  `userID` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  KEY `ID` (`ID`),
  CONSTRAINT `FK_tblmembercredentials_tblmember` FOREIGN KEY (`ID`) REFERENCES `tblmember` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table dbmmis.tblmembercredentials: ~4 rows (approximately)
/*!40000 ALTER TABLE `tblmembercredentials` DISABLE KEYS */;
INSERT INTO `tblmembercredentials` (`ID`, `userID`, `password`) VALUES
	(54, 'JanMaverickAlqueza', '2tD$5Nkr'),
	(55, 'asdasadsad', '@SVVct6d'),
	(56, 'asdadasdasd', 'ckE4qH%z'),
	(57, 'asdadasdasd', 'C*c!s49Q'),
	(58, 'asdsadasdasasdasd', '6S*ptKD6');
/*!40000 ALTER TABLE `tblmembercredentials` ENABLE KEYS */;

-- Dumping structure for table dbmmis.tblmemberimg
DROP TABLE IF EXISTS `tblmemberimg`;
CREATE TABLE IF NOT EXISTS `tblmemberimg` (
  `ID` int(11) NOT NULL,
  `imgurl` varchar(150) NOT NULL,
  KEY `ID` (`ID`),
  CONSTRAINT `FK_tblmemberimg_tblmember` FOREIGN KEY (`ID`) REFERENCES `tblmember` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table dbmmis.tblmemberimg: ~1 rows (approximately)
/*!40000 ALTER TABLE `tblmemberimg` DISABLE KEYS */;
INSERT INTO `tblmemberimg` (`ID`, `imgurl`) VALUES
	(56, '/mmis/profile/photo/56.png'),
	(57, '/mmis/profile/photo/57.png');
/*!40000 ALTER TABLE `tblmemberimg` ENABLE KEYS */;

-- Dumping structure for table dbmmis.tblmemberpublicid
DROP TABLE IF EXISTS `tblmemberpublicid`;
CREATE TABLE IF NOT EXISTS `tblmemberpublicid` (
  `ID` int(11) NOT NULL,
  `userID` varchar(150) NOT NULL,
  KEY `ID` (`ID`),
  CONSTRAINT `FK_tblmemberpublicID_tblmember` FOREIGN KEY (`ID`) REFERENCES `tblmember` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table dbmmis.tblmemberpublicid: ~0 rows (approximately)
/*!40000 ALTER TABLE `tblmemberpublicid` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblmemberpublicid` ENABLE KEYS */;

-- Dumping structure for table dbmmis.tblmemberstatus
DROP TABLE IF EXISTS `tblmemberstatus`;
CREATE TABLE IF NOT EXISTS `tblmemberstatus` (
  `ID` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  KEY `ID` (`ID`),
  CONSTRAINT `FK_tblmemberstatus_tblmember` FOREIGN KEY (`ID`) REFERENCES `tblmember` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table dbmmis.tblmemberstatus: ~4 rows (approximately)
/*!40000 ALTER TABLE `tblmemberstatus` DISABLE KEYS */;
INSERT INTO `tblmemberstatus` (`ID`, `status`) VALUES
	(54, 'ACTIVE'),
	(55, 'ACTIVE'),
	(56, 'ACTIVE'),
	(57, 'ACTIVE'),
	(58, 'ACTIVE');
/*!40000 ALTER TABLE `tblmemberstatus` ENABLE KEYS */;

-- Dumping structure for table dbmmis.tbluser
DROP TABLE IF EXISTS `tbluser`;
CREATE TABLE IF NOT EXISTS `tbluser` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table dbmmis.tbluser: ~0 rows (approximately)
/*!40000 ALTER TABLE `tbluser` DISABLE KEYS */;
INSERT INTO `tbluser` (`ID`, `username`, `password`, `fullname`) VALUES
	(1, 'admin', 'admin', 'Mavs Alqueza');
/*!40000 ALTER TABLE `tbluser` ENABLE KEYS */;

-- Dumping structure for view dbmmis.credentialview
DROP VIEW IF EXISTS `credentialview`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `credentialview`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `credentialview` AS SELECT m.ID as 'ID',CONCAT(m.fname,' ',m.lname) as 'name',i.imgurl as  'url',c.userID as 'userID',c.password as 'password' FROM tblmember m
LEFT JOIN tblmemberimg i ON i.ID = m.ID 
LEFT JOIN tblmembercredentials c ON c.ID = m.ID ;

-- Dumping structure for view dbmmis.memberview
DROP VIEW IF EXISTS `memberview`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `memberview`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `memberview` AS SELECT m.*,i.imgurl,s.`status` from tblmember m
LEFT JOIN tblmemberimg i ON i.ID = m.ID
LEFT JOIN tblmemberstatus s ON s.ID = m.ID ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
