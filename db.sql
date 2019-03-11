-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.35-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             10.1.0.5464
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
	`brgyID` INT(11) NOT NULL,
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
	`date_created` TIMESTAMP NOT NULL,
	`brgy` VARCHAR(150) NULL COLLATE 'utf8_general_ci',
	`imgurl` VARCHAR(150) NULL COLLATE 'utf8_general_ci',
	`status` VARCHAR(50) NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view dbmmis.seniorloggedinview
DROP VIEW IF EXISTS `seniorloggedinview`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `seniorloggedinview` (
	`ID` INT(11) NOT NULL,
	`User` VARCHAR(101) NOT NULL COLLATE 'utf8_general_ci',
	`LoggedAt` DATETIME NULL
) ENGINE=MyISAM;

-- Dumping structure for table dbmmis.tblbrgy
DROP TABLE IF EXISTS `tblbrgy`;
CREATE TABLE IF NOT EXISTS `tblbrgy` (
  `brgyID` int(11) NOT NULL AUTO_INCREMENT,
  `brgy` varchar(150) NOT NULL,
  PRIMARY KEY (`brgyID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table dbmmis.tblcomposition
DROP TABLE IF EXISTS `tblcomposition`;
CREATE TABLE IF NOT EXISTS `tblcomposition` (
  `ID` int(11) DEFAULT NULL,
  `compoID` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `relationship` varchar(150) NOT NULL,
  `c_age` tinyint(4) NOT NULL,
  `c_civil_status` varchar(50) NOT NULL,
  `c_occupation` varchar(150) NOT NULL,
  `c_income` decimal(10,0) NOT NULL,
  PRIMARY KEY (`compoID`),
  KEY `ID` (`ID`),
  CONSTRAINT `FK_tblcomposition_tblmember` FOREIGN KEY (`ID`) REFERENCES `tblmember` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table dbmmis.tblloggedinsenior
DROP TABLE IF EXISTS `tblloggedinsenior`;
CREATE TABLE IF NOT EXISTS `tblloggedinsenior` (
  `userID` int(11) DEFAULT NULL,
  `datelogged` datetime DEFAULT NULL,
  KEY `userID` (`userID`),
  CONSTRAINT `FK_tblloggedinsenior_tblmember` FOREIGN KEY (`userID`) REFERENCES `tblmember` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table dbmmis.tblloggedinuser
DROP TABLE IF EXISTS `tblloggedinuser`;
CREATE TABLE IF NOT EXISTS `tblloggedinuser` (
  `userID` int(11) DEFAULT NULL,
  `datelogged` datetime DEFAULT NULL,
  KEY `userID` (`userID`),
  CONSTRAINT `FK_tblloggedin_tbluser` FOREIGN KEY (`userID`) REFERENCES `tbluser` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table dbmmis.tblmember
DROP TABLE IF EXISTS `tblmember`;
CREATE TABLE IF NOT EXISTS `tblmember` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `brgyID` int(11) NOT NULL,
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
  PRIMARY KEY (`ID`),
  KEY `brgyID` (`brgyID`),
  CONSTRAINT `FK_tblmember_tblbrgy` FOREIGN KEY (`brgyID`) REFERENCES `tblbrgy` (`brgyID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table dbmmis.tblmembercreatedby
DROP TABLE IF EXISTS `tblmembercreatedby`;
CREATE TABLE IF NOT EXISTS `tblmembercreatedby` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `memberID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `memberID` (`memberID`),
  KEY `userID` (`userID`),
  CONSTRAINT `FK_tblmembercreateby_tblmember` FOREIGN KEY (`memberID`) REFERENCES `tblmember` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_tblmembercreateby_tbluser` FOREIGN KEY (`userID`) REFERENCES `tbluser` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table dbmmis.tblmembercredentials
DROP TABLE IF EXISTS `tblmembercredentials`;
CREATE TABLE IF NOT EXISTS `tblmembercredentials` (
  `ID` int(11) NOT NULL,
  `userID` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  KEY `ID` (`ID`),
  CONSTRAINT `FK_tblmembercredentials_tblmember` FOREIGN KEY (`ID`) REFERENCES `tblmember` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table dbmmis.tblmemberimg
DROP TABLE IF EXISTS `tblmemberimg`;
CREATE TABLE IF NOT EXISTS `tblmemberimg` (
  `ID` int(11) NOT NULL,
  `imgurl` varchar(150) NOT NULL,
  KEY `ID` (`ID`),
  CONSTRAINT `FK_tblmemberimg_tblmember` FOREIGN KEY (`ID`) REFERENCES `tblmember` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table dbmmis.tblmemberpublicid
DROP TABLE IF EXISTS `tblmemberpublicid`;
CREATE TABLE IF NOT EXISTS `tblmemberpublicid` (
  `ID` int(11) NOT NULL,
  `userID` varchar(150) NOT NULL,
  KEY `ID` (`ID`),
  CONSTRAINT `FK_tblmemberpublicID_tblmember` FOREIGN KEY (`ID`) REFERENCES `tblmember` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table dbmmis.tblmemberstatus
DROP TABLE IF EXISTS `tblmemberstatus`;
CREATE TABLE IF NOT EXISTS `tblmemberstatus` (
  `ID` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  KEY `ID` (`ID`),
  CONSTRAINT `FK_tblmemberstatus_tblmember` FOREIGN KEY (`ID`) REFERENCES `tblmember` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table dbmmis.tblsuperuser
DROP TABLE IF EXISTS `tblsuperuser`;
CREATE TABLE IF NOT EXISTS `tblsuperuser` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table dbmmis.tbluser
DROP TABLE IF EXISTS `tbluser`;
CREATE TABLE IF NOT EXISTS `tbluser` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for view dbmmis.userloggedinview
DROP VIEW IF EXISTS `userloggedinview`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `userloggedinview` (
	`User` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`LoggedAt` DATETIME NULL
) ENGINE=MyISAM;

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
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `memberview` AS SELECT m.*,b.brgy,i.imgurl,s.`status` from tblmember m
LEFT JOIN tblmemberimg i ON i.ID = m.ID
LEFT JOIN tblmemberstatus s ON s.ID = m.ID 
LEFT JOIN tblbrgy as b ON b.brgyID = m.brgyID ;

-- Dumping structure for view dbmmis.seniorloggedinview
DROP VIEW IF EXISTS `seniorloggedinview`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `seniorloggedinview`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `seniorloggedinview` AS SELECT
	m.ID as ID,CONCAT(m.fname,' ',m.lname) AS User,
	l.datelogged AS LoggedAt 
FROM
	tblloggedinsenior AS l
	INNER JOIN tblmember AS m ON m.ID = l.userID 
ORDER BY
	l.datelogged DESC ;

-- Dumping structure for view dbmmis.userloggedinview
DROP VIEW IF EXISTS `userloggedinview`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `userloggedinview`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `userloggedinview` AS SELECT
	u.fullname AS User,
	l.datelogged AS LoggedAt 
FROM
	tblloggedinuser AS l
	INNER JOIN tbluser AS u ON u.ID = l.userID 
ORDER BY
	l.datelogged DESC ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
