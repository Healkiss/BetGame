-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 19, 2013 at 08:30 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `betgame`
--

-- --------------------------------------------------------

--
-- Table structure for table `bet`
--

CREATE TABLE IF NOT EXISTS `bet` (
  `idBET` int(11) NOT NULL AUTO_INCREMENT,
  `Winner` int(11) DEFAULT NULL,
  `Price` varchar(45) DEFAULT NULL,
  `USER_idUSER` int(11) NOT NULL,
  `MATCH_idMATCH` int(11) NOT NULL,
  PRIMARY KEY (`idBET`),
  KEY `fk_BET_USER1_idx` (`USER_idUSER`),
  KEY `fk_BET_MATCH1_idx` (`MATCH_idMATCH`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contest`
--

CREATE TABLE IF NOT EXISTS `contest` (
  `idCONTEST` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Description` text,
  `Price` varchar(45) DEFAULT NULL,
  `Location` varchar(45) DEFAULT NULL,
  `Startdate` int(11) NOT NULL DEFAULT '0',
  `Enddate` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idCONTEST`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `contest`
--

INSERT INTO `contest` (`idCONTEST`, `Name`, `Description`, `Price`, `Location`, `Startdate`, `Enddate`) VALUES
(1, 'Compet1', NULL, '12000', 'Toulouse', 1311645012, 1363645012),
(2, 'Compet2', NULL, '13000', 'Bordeaux', 1311645012, 1363645012),
(3, 'Compet3', NULL, '30000', 'Pechabou', 1361645012, 0);

-- --------------------------------------------------------

--
-- Table structure for table `contest_match`
--

CREATE TABLE IF NOT EXISTS `contest_match` (
  `MATCH_idMATCH` int(11) NOT NULL,
  `CONTEST_idCONTEST` int(11) NOT NULL,
  PRIMARY KEY (`MATCH_idMATCH`,`CONTEST_idCONTEST`),
  KEY `fk_MATCH_has_CONTEST_CONTEST1_idx` (`CONTEST_idCONTEST`),
  KEY `fk_MATCH_has_CONTEST_MATCH1_idx` (`MATCH_idMATCH`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contest_match`
--

INSERT INTO `contest_match` (`MATCH_idMATCH`, `CONTEST_idCONTEST`) VALUES
(1, 1),
(3, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `gamer`
--

CREATE TABLE IF NOT EXISTS `gamer` (
  `idGAMER` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Birthdate` datetime DEFAULT NULL,
  `Description` text,
  `Nationality` int(11) DEFAULT NULL,
  PRIMARY KEY (`idGAMER`),
  UNIQUE KEY `idGAMER_UNIQUE` (`idGAMER`),
  KEY `Nationality_idx` (`Nationality`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `gamer`
--

INSERT INTO `gamer` (`idGAMER`, `Name`, `Birthdate`, `Description`, `Nationality`) VALUES
(1, 'gamer1', NULL, NULL, NULL),
(2, 'gamer2', NULL, NULL, NULL),
(3, 'gamer3', NULL, NULL, NULL),
(4, 'gamer4', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gamer_videogame`
--

CREATE TABLE IF NOT EXISTS `gamer_videogame` (
  `GAMER_idGAMER` int(11) NOT NULL,
  `VIDEOGAME_idVIDEOGAME` int(11) NOT NULL,
  PRIMARY KEY (`GAMER_idGAMER`,`VIDEOGAME_idVIDEOGAME`),
  KEY `fk_GAMER_has_VIDEOGAME_VIDEOGAME1_idx` (`VIDEOGAME_idVIDEOGAME`),
  KEY `fk_GAMER_has_VIDEOGAME_GAMER1_idx` (`GAMER_idGAMER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `match`
--

CREATE TABLE IF NOT EXISTS `match` (
  `idMATCH` int(11) NOT NULL AUTO_INCREMENT,
  `Description` text,
  `Startdate` datetime DEFAULT NULL,
  `Enddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idMATCH`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `match`
--

INSERT INTO `match` (`idMATCH`, `Description`, `Startdate`, `Enddate`) VALUES
(1, 'match1', NULL, NULL),
(2, 'Match2', NULL, NULL),
(3, 'Match3', NULL, NULL),
(4, 'Match2', NULL, NULL),
(5, 'Match3', NULL, NULL),
(6, 'Match4', NULL, NULL),
(7, 'Match5', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `match_gamer`
--

CREATE TABLE IF NOT EXISTS `match_gamer` (
  `GAMER_idGAMER` int(11) NOT NULL,
  `MATCH_idMATCH` int(11) NOT NULL,
  `Side` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`GAMER_idGAMER`,`MATCH_idMATCH`),
  KEY `fk_GAMER_has_MATCH_MATCH1_idx` (`MATCH_idMATCH`),
  KEY `fk_GAMER_has_MATCH_GAMER1_idx` (`GAMER_idGAMER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `match_gamer`
--

INSERT INTO `match_gamer` (`GAMER_idGAMER`, `MATCH_idMATCH`, `Side`) VALUES
(1, 1, '1'),
(1, 2, '1'),
(1, 3, '2'),
(2, 1, '2'),
(3, 3, '1'),
(4, 2, '2');

-- --------------------------------------------------------

--
-- Table structure for table `match_score`
--

CREATE TABLE IF NOT EXISTS `match_score` (
  `SCORE_idScore` int(11) NOT NULL,
  `MATCH_idMATCH` int(11) NOT NULL,
  `Side` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`SCORE_idScore`,`MATCH_idMATCH`),
  KEY `fk_SCORE_has_MATCH_MATCH1_idx` (`MATCH_idMATCH`),
  KEY `fk_SCORE_has_MATCH_SCORE1_idx` (`SCORE_idScore`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nationality`
--

CREATE TABLE IF NOT EXISTS `nationality` (
  `idNATIONALITY` int(11) NOT NULL AUTO_INCREMENT,
  `Locale` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idNATIONALITY`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE IF NOT EXISTS `score` (
  `idScore` int(11) NOT NULL AUTO_INCREMENT,
  `Score` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idScore`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `idTYPE` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Description` text,
  PRIMARY KEY (`idTYPE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `idUSER` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Nickname` varchar(45) DEFAULT NULL,
  `Description` text,
  `Birthdate` datetime DEFAULT NULL,
  `Bank` float DEFAULT NULL,
  `RegistrationDate` int(11) NOT NULL,
  PRIMARY KEY (`idUSER`),
  UNIQUE KEY `idUSER_UNIQUE` (`idUSER`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUSER`, `Name`, `Password`, `Nickname`, `Description`, `Birthdate`, `Bank`, `RegistrationDate`) VALUES
(1, 'François', NULL, 'User1', NULL, NULL, 100, 1313664445),
(2, 'Jean', NULL, 'user2', NULL, NULL, 200, 1361364445),
(3, 'Cecile', NULL, 'user3', NULL, NULL, 300, 1363644445);

-- --------------------------------------------------------

--
-- Table structure for table `videogame`
--

CREATE TABLE IF NOT EXISTS `videogame` (
  `idVIDEOGAME` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Description` text,
  `Year` int(11) DEFAULT NULL,
  `Studio` varchar(45) DEFAULT NULL,
  `Editor` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idVIDEOGAME`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `videogame`
--

INSERT INTO `videogame` (`idVIDEOGAME`, `Name`, `Description`, `Year`, `Studio`, `Editor`) VALUES
(1, 'Jeux1', NULL, NULL, NULL, NULL),
(2, 'Jeux2', NULL, NULL, NULL, NULL),
(3, 'Jeux3', NULL, NULL, NULL, NULL),
(4, 'Jeux4', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `videogame_type`
--

CREATE TABLE IF NOT EXISTS `videogame_type` (
  `TYPE_idTYPE` int(11) NOT NULL,
  `VIDEOGAME_idVIDEOGAME` int(11) NOT NULL,
  PRIMARY KEY (`TYPE_idTYPE`,`VIDEOGAME_idVIDEOGAME`),
  KEY `fk_TYPE_has_VIDEOGAME_VIDEOGAME1_idx` (`VIDEOGAME_idVIDEOGAME`),
  KEY `fk_TYPE_has_VIDEOGAME_TYPE1_idx` (`TYPE_idTYPE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bet`
--
ALTER TABLE `bet`
  ADD CONSTRAINT `fk_BET_USER1` FOREIGN KEY (`USER_idUSER`) REFERENCES `user` (`idUSER`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_BET_MATCH1` FOREIGN KEY (`MATCH_idMATCH`) REFERENCES `match` (`idMATCH`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `contest_match`
--
ALTER TABLE `contest_match`
  ADD CONSTRAINT `fk_MATCH_has_CONTEST_MATCH1` FOREIGN KEY (`MATCH_idMATCH`) REFERENCES `match` (`idMATCH`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_MATCH_has_CONTEST_CONTEST1` FOREIGN KEY (`CONTEST_idCONTEST`) REFERENCES `contest` (`idCONTEST`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `gamer`
--
ALTER TABLE `gamer`
  ADD CONSTRAINT `Nationality` FOREIGN KEY (`Nationality`) REFERENCES `nationality` (`idNATIONALITY`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `gamer_videogame`
--
ALTER TABLE `gamer_videogame`
  ADD CONSTRAINT `fk_GAMER_has_VIDEOGAME_GAMER1` FOREIGN KEY (`GAMER_idGAMER`) REFERENCES `gamer` (`idGAMER`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_GAMER_has_VIDEOGAME_VIDEOGAME1` FOREIGN KEY (`VIDEOGAME_idVIDEOGAME`) REFERENCES `videogame` (`idVIDEOGAME`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `match_gamer`
--
ALTER TABLE `match_gamer`
  ADD CONSTRAINT `fk_GAMER_has_MATCH_GAMER1` FOREIGN KEY (`GAMER_idGAMER`) REFERENCES `gamer` (`idGAMER`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_GAMER_has_MATCH_MATCH1` FOREIGN KEY (`MATCH_idMATCH`) REFERENCES `match` (`idMATCH`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `match_score`
--
ALTER TABLE `match_score`
  ADD CONSTRAINT `fk_SCORE_has_MATCH_SCORE1` FOREIGN KEY (`SCORE_idScore`) REFERENCES `score` (`idScore`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_SCORE_has_MATCH_MATCH1` FOREIGN KEY (`MATCH_idMATCH`) REFERENCES `match` (`idMATCH`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `videogame_type`
--
ALTER TABLE `videogame_type`
  ADD CONSTRAINT `fk_TYPE_has_VIDEOGAME_TYPE1` FOREIGN KEY (`TYPE_idTYPE`) REFERENCES `type` (`idTYPE`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TYPE_has_VIDEOGAME_VIDEOGAME1` FOREIGN KEY (`VIDEOGAME_idVIDEOGAME`) REFERENCES `videogame` (`idVIDEOGAME`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
