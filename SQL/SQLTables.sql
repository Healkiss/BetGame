SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `bet` (
  `idBET` int(11) NOT NULL AUTO_INCREMENT,
  `Winner` int(11) DEFAULT NULL,
  `Price` varchar(45) DEFAULT NULL,
  `USER_idUSER` int(11) NOT NULL,
  `MATCH_idMATCH` int(11) NOT NULL,
  PRIMARY KEY (`idBET`),
  KEY `fk_BET_USER1_idx` (`USER_idUSER`),
  KEY `fk_BET_MATCH1_idx` (`MATCH_idMATCH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `contest` (
  `idCONTEST` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Description` text,
  `Price` varchar(45) DEFAULT NULL,
  `Location` varchar(45) DEFAULT NULL,
  `Startdate` datetime NOT NULL,
  `Enddate` datetime NOT NULL,
  PRIMARY KEY (`idCONTEST`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `country` (
  `idCOUNTRY` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `alpha2` varchar(2) NOT NULL,
  `alpha3` varchar(3) NOT NULL,
  `nameUS` varchar(45) NOT NULL,
  `nameFR` varchar(45) NOT NULL,
  PRIMARY KEY (`idCOUNTRY`),
  UNIQUE KEY `alpha2` (`alpha2`),
  UNIQUE KEY `alpha3` (`alpha3`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `editor` (
  `idEditor` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idEditor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `gamer` (
  `idGAMER` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Birthdate` datetime DEFAULT NULL,
  `Description` text,
  `idCOUNTRY` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`idGAMER`),
  KEY `idCOUNTRY_fk` (`idCOUNTRY`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `gamer_videogame` (
  `GAMER_idGAMER` int(11) NOT NULL,
  `VIDEOGAME_idVIDEOGAME` int(11) NOT NULL,
  PRIMARY KEY (`GAMER_idGAMER`,`VIDEOGAME_idVIDEOGAME`),
  KEY `fk_GAMER_has_VIDEOGAME_VIDEOGAME1_idx` (`VIDEOGAME_idVIDEOGAME`),
  KEY `fk_GAMER_has_VIDEOGAME_GAMER1_idx` (`GAMER_idGAMER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `match` (
  `idMATCH` int(11) NOT NULL AUTO_INCREMENT,
  `Description` text,
  `Startdate` datetime DEFAULT NULL,
  `Enddate` datetime DEFAULT NULL,
  `idCONTEST` int(11) NOT NULL,
  PRIMARY KEY (`idMATCH`),
  KEY `idCONTEST` (`idCONTEST`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `match_gamer` (
  `GAMER_idGAMER` int(11) NOT NULL,
  `MATCH_idMATCH` int(11) NOT NULL,
  `Side` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`GAMER_idGAMER`,`MATCH_idMATCH`),
  KEY `fk_GAMER_has_MATCH_MATCH1_idx` (`MATCH_idMATCH`),
  KEY `GAMER_idGAMER` (`GAMER_idGAMER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `match_score` (
  `SCORE_idSCORE` int(11) NOT NULL,
  `MATCH_idMATCH` int(11) NOT NULL,
  `Side` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`SCORE_idSCORE`,`MATCH_idMATCH`),
  KEY `fk_SCORE_has_MATCH_MATCH1_idx` (`MATCH_idMATCH`),
  KEY `fk_SCORE_has_MATCH_SCORE1_idx` (`SCORE_idSCORE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `score` (
  `idScore` int(11) NOT NULL AUTO_INCREMENT,
  `Score` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idScore`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `studio` (
  `idStudio` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idStudio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `type` (
  `idTYPE` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Description` text,
  PRIMARY KEY (`idTYPE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user` (
  `idUSER` int(11) NOT NULL AUTO_INCREMENT,
  `First_name` varchar(45) DEFAULT NULL,
  `Last_name` varchar(45) NOT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Nickname` varchar(45) DEFAULT NULL,
  `Description` text,
  `Birthdate` datetime DEFAULT NULL,
  `Bank` float DEFAULT NULL,
  `RegistrationDate` datetime NOT NULL,
  PRIMARY KEY (`idUSER`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `videogame` (
  `idVIDEOGAME` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Description` text,
  `Year` int(11) DEFAULT NULL,
  `idStudio` int(11) DEFAULT NULL,
  `idEditor` int(11) DEFAULT NULL,
  PRIMARY KEY (`idVIDEOGAME`),
  KEY `idStudio` (`idStudio`),
  KEY `idEditor` (`idEditor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `videogame_type` (
  `TYPE_idTYPE` int(11) NOT NULL,
  `VIDEOGAME_idVIDEOGAME` int(11) NOT NULL,
  PRIMARY KEY (`TYPE_idTYPE`,`VIDEOGAME_idVIDEOGAME`),
  KEY `fk_TYPE_has_VIDEOGAME_VIDEOGAME1_idx` (`VIDEOGAME_idVIDEOGAME`),
  KEY `fk_TYPE_has_VIDEOGAME_TYPE1_idx` (`TYPE_idTYPE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `bet`
  ADD CONSTRAINT `fk_BET_MATCH1` FOREIGN KEY (`MATCH_idMATCH`) REFERENCES `match` (`idMATCH`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_BET_USER1` FOREIGN KEY (`USER_idUSER`) REFERENCES `user` (`idUSER`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `gamer`
  ADD CONSTRAINT `gamer_ibfk_2` FOREIGN KEY (`idCOUNTRY`) REFERENCES `country` (`idCOUNTRY`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `gamer_ibfk_1` FOREIGN KEY (`idCOUNTRY`) REFERENCES `country` (`idCOUNTRY`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `gamer_videogame`
  ADD CONSTRAINT `gamer_videogame_ibfk_1` FOREIGN KEY (`GAMER_idGAMER`) REFERENCES `gamer` (`idGAMER`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_GAMER_has_VIDEOGAME_VIDEOGAME1` FOREIGN KEY (`VIDEOGAME_idVIDEOGAME`) REFERENCES `videogame` (`idVIDEOGAME`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `match`
  ADD CONSTRAINT `match_ibfk_2` FOREIGN KEY (`idCONTEST`) REFERENCES `contest` (`idCONTEST`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `match_gamer`
  ADD CONSTRAINT `match_gamer_ibfk_3` FOREIGN KEY (`MATCH_idMATCH`) REFERENCES `match` (`idMATCH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `match_gamer_ibfk_2` FOREIGN KEY (`GAMER_idGAMER`) REFERENCES `gamer` (`idGAMER`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `match_score`
  ADD CONSTRAINT `match_score_ibfk_1` FOREIGN KEY (`SCORE_idSCORE`) REFERENCES `score` (`idScore`),
  ADD CONSTRAINT `fk_SCORE_has_MATCH_MATCH1` FOREIGN KEY (`MATCH_idMATCH`) REFERENCES `match` (`idMATCH`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_SCORE_has_MATCH_SCORE1` FOREIGN KEY (`SCORE_idScore`) REFERENCES `score` (`idScore`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `videogame`
  ADD CONSTRAINT `videogame_ibfk_2` FOREIGN KEY (`idEditor`) REFERENCES `editor` (`idEditor`),
  ADD CONSTRAINT `videogame_ibfk_1` FOREIGN KEY (`idStudio`) REFERENCES `studio` (`idStudio`);

ALTER TABLE `videogame_type`
  ADD CONSTRAINT `fk_TYPE_has_VIDEOGAME_TYPE1` FOREIGN KEY (`TYPE_idTYPE`) REFERENCES `type` (`idTYPE`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TYPE_has_VIDEOGAME_VIDEOGAME1` FOREIGN KEY (`VIDEOGAME_idVIDEOGAME`) REFERENCES `videogame` (`idVIDEOGAME`) ON DELETE NO ACTION ON UPDATE NO ACTION;


-- Triggers
-- Ne marche pas sur l'hébergement en ligne mais fonctionne de manière générale


DROP TRIGGER IF EXISTS `betInsertTrigger`;
DELIMITER //
CREATE TRIGGER `betInsertTrigger`
BEFORE INSERT
ON `bet`
FOR EACH ROW
BEGIN
	IF (NEW.Price <0) THEN
		SET NEW.Price = 0;
	END IF;
END//
DELIMITER ;

DROP TRIGGER IF EXISTS `betUpdateTrigger`;
DELIMITER //
CREATE TRIGGER `betUpdateTrigger`
BEFORE UPDATE
ON `bet`
FOR EACH ROW
BEGIN
	IF (NEW.Price <0) THEN
		SET NEW.Price = 0;
	END IF;
END//
DELIMITER ;
 
DROP TRIGGER IF EXISTS `contestInsertTrigger`;
DELIMITER //
CREATE TRIGGER `contestInsertTrigger`
BEFORE INSERT
ON `contest`
FOR EACH ROW
BEGIN
	DECLARE dateError CONDITION FOR SQLSTATE '45000';

	IF NEW.Startdate > NEW.Enddate THEN
		SIGNAL dateError
			SET MESSAGE_TEXT = 'La date de debut est postérieure a la date fin' , MYSQL_ERRNO = 1002;
	END IF;
END//
DELIMITER ; 

DROP TRIGGER IF EXISTS `contestUpdateTrigger`;
DELIMITER //
CREATE TRIGGER `contestUpdateTrigger`
BEFORE UPDATE
ON `contest`
FOR EACH ROW
BEGIN
	DECLARE dateError CONDITION FOR SQLSTATE '45000';

	IF NEW.Startdate > NEW.Enddate THEN
		SIGNAL dateError
			SET MESSAGE_TEXT = 'La date de debut est postérieure a la date fin' , MYSQL_ERRNO = 1002;
	END IF;
END//
DELIMITER ;

DROP TRIGGER IF EXISTS `matchInsertTrigger`;
DELIMITER //
CREATE TRIGGER `matchInsertTrigger`
BEFORE INSERT
ON `match`
FOR EACH ROW
BEGIN
	DECLARE dateError CONDITION FOR SQLSTATE '45000';

	IF NEW.Startdate > NEW.Enddate THEN
		SIGNAL dateError
			SET MESSAGE_TEXT = 'La date de debut est postérieure a la fin du match' , MYSQL_ERRNO = 1002;
	ELSE
		SET @contestStartdate := (SELECT Startdate FROM `contest` WHERE idCONTEST = NEW.idCONTEST);
		IF NEW.Startdate < @contestStartdate THEN
			SIGNAL dateError
				SET MESSAGE_TEXT = 'La date de début du match est anterieure au commencement de la competition' , MYSQL_ERRNO = 1002;
		ELSE
			SET @contestEnddate := (SELECT Enddate FROM `contest` WHERE idCONTEST = NEW.idCONTEST);
			IF NEW.Enddate > @contestEnddate THEN
				SIGNAL dateError
					SET MESSAGE_TEXT = 'La date de fin du match est postérieur a la fin de la competition' , MYSQL_ERRNO = 1002;
			END IF;
		END IF;
	END IF;
END//
DELIMITER ;

DROP TRIGGER IF EXISTS `matchUpdateTrigger`;
DELIMITER //
CREATE TRIGGER `matchUpdateTrigger`
BEFORE UPDATE
ON `match`
FOR EACH ROW
BEGIN
	DECLARE dateError CONDITION FOR SQLSTATE '45000';

	IF NEW.Startdate > NEW.Enddate THEN
		SIGNAL dateError
			SET MESSAGE_TEXT = 'La date de debut est postérieure a la fin du match' , MYSQL_ERRNO = 1002;
	ELSE
		SET @contestStartdate := (SELECT Startdate FROM `contest` WHERE idCONTEST = NEW.idCONTEST);
		IF NEW.Startdate < @contestStartdate THEN
			SIGNAL dateError
				SET MESSAGE_TEXT = 'La date de début du match est anterieure au commencement de la competition' , MYSQL_ERRNO = 1002;
		ELSE
			SET @contestEnddate := (SELECT Enddate FROM `contest` WHERE idCONTEST = NEW.idCONTEST);
			IF NEW.Enddate > @contestEnddate THEN
				SIGNAL dateError
					SET MESSAGE_TEXT = 'La date de fin du match est postérieur a la fin de la competition' , MYSQL_ERRNO = 1002;
			END IF;
		END IF;
	END IF;
END//
DELIMITER ;
