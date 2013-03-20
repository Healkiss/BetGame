SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `BetGame`.`USER`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BetGame`.`USER` (
  `idUSER` INT NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(45) NULL ,
  `Password` VARCHAR(255) NULL ,
  `Nickname` VARCHAR(45) NULL ,
  `Description` TEXT NULL ,
  `Birthdate` DATETIME NULL ,
  `Bank` FLOAT NULL ,
  PRIMARY KEY (`idUSER`) ,
  UNIQUE INDEX `idUSER_UNIQUE` (`idUSER` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BetGame`.`SCORE`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BetGame`.`SCORE` (
  `idScore` INT NOT NULL AUTO_INCREMENT ,
  `Score` VARCHAR(45) NULL ,
  PRIMARY KEY (`idScore`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BetGame`.`TYPE`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BetGame`.`TYPE` (
  `idTYPE` INT NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(45) NULL ,
  `Description` TEXT NULL ,
  PRIMARY KEY (`idTYPE`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BetGame`.`MATCH`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BetGame`.`MATCH` (
  `idMATCH` INT NOT NULL AUTO_INCREMENT ,
  `Description` TEXT NULL ,
  `Startdate` DATETIME NULL ,
  `Enddate` DATETIME NULL ,
  PRIMARY KEY (`idMATCH`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BetGame`.`BET`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BetGame`.`BET` (
  `idBET` INT NOT NULL AUTO_INCREMENT ,
  `Winner` INT NULL ,
  `Price` VARCHAR(45) NULL ,
  `USER_idUSER` INT NOT NULL ,
  `MATCH_idMATCH` INT NOT NULL ,
  PRIMARY KEY (`idBET`) ,
  INDEX `fk_BET_USER1_idx` (`USER_idUSER` ASC) ,
  INDEX `fk_BET_MATCH1_idx` (`MATCH_idMATCH` ASC) ,
  CONSTRAINT `fk_BET_USER1`
    FOREIGN KEY (`USER_idUSER` )
    REFERENCES `BetGame`.`USER` (`idUSER` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_BET_MATCH1`
    FOREIGN KEY (`MATCH_idMATCH` )
    REFERENCES `BetGame`.`MATCH` (`idMATCH` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BetGame`.`NATIONALITY`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BetGame`.`NATIONALITY` (
  `idNATIONALITY` INT NOT NULL AUTO_INCREMENT ,
  `Locale` VARCHAR(45) NULL ,
  PRIMARY KEY (`idNATIONALITY`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BetGame`.`GAMER`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BetGame`.`GAMER` (
  `idGAMER` INT NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(45) NULL ,
  `Birthdate` DATETIME NULL ,
  `Description` TEXT NULL ,
  `Nationality` INT NULL ,
  PRIMARY KEY (`idGAMER`) ,
  UNIQUE INDEX `idGAMER_UNIQUE` (`idGAMER` ASC) ,
  INDEX `Nationality_idx` (`Nationality` ASC) ,
  CONSTRAINT `Nationality`
    FOREIGN KEY (`Nationality` )
    REFERENCES `BetGame`.`NATIONALITY` (`idNATIONALITY` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BetGame`.`VIDEOGAME`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BetGame`.`VIDEOGAME` (
  `idVIDEOGAME` INT NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(45) NULL ,
  `Description` TEXT NULL ,
  `Year` INT NULL ,
  `Studio` VARCHAR(45) NULL ,
  `Editor` VARCHAR(45) NULL ,
  PRIMARY KEY (`idVIDEOGAME`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BetGame`.`CONTEST`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BetGame`.`CONTEST` (
  `idCONTEST` INT NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(45) NULL ,
  `Description` TEXT NULL ,
  `Price` VARCHAR(45) NULL ,
  `Location` VARCHAR(45) NULL ,
  PRIMARY KEY (`idCONTEST`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BetGame`.`MATCH_SCORE`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BetGame`.`MATCH_SCORE` (
  `SCORE_idScore` INT NOT NULL ,
  `MATCH_idMATCH` INT NOT NULL ,
  `Side` VARCHAR(45) NULL ,
  PRIMARY KEY (`SCORE_idScore`, `MATCH_idMATCH`) ,
  INDEX `fk_SCORE_has_MATCH_MATCH1_idx` (`MATCH_idMATCH` ASC) ,
  INDEX `fk_SCORE_has_MATCH_SCORE1_idx` (`SCORE_idScore` ASC) ,
  CONSTRAINT `fk_SCORE_has_MATCH_SCORE1`
    FOREIGN KEY (`SCORE_idScore` )
    REFERENCES `BetGame`.`SCORE` (`idScore` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_SCORE_has_MATCH_MATCH1`
    FOREIGN KEY (`MATCH_idMATCH` )
    REFERENCES `BetGame`.`MATCH` (`idMATCH` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BetGame`.`VIDEOGAME_TYPE`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BetGame`.`VIDEOGAME_TYPE` (
  `TYPE_idTYPE` INT NOT NULL ,
  `VIDEOGAME_idVIDEOGAME` INT NOT NULL ,
  PRIMARY KEY (`TYPE_idTYPE`, `VIDEOGAME_idVIDEOGAME`) ,
  INDEX `fk_TYPE_has_VIDEOGAME_VIDEOGAME1_idx` (`VIDEOGAME_idVIDEOGAME` ASC) ,
  INDEX `fk_TYPE_has_VIDEOGAME_TYPE1_idx` (`TYPE_idTYPE` ASC) ,
  CONSTRAINT `fk_TYPE_has_VIDEOGAME_TYPE1`
    FOREIGN KEY (`TYPE_idTYPE` )
    REFERENCES `BetGame`.`TYPE` (`idTYPE` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TYPE_has_VIDEOGAME_VIDEOGAME1`
    FOREIGN KEY (`VIDEOGAME_idVIDEOGAME` )
    REFERENCES `BetGame`.`VIDEOGAME` (`idVIDEOGAME` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BetGame`.`CONTEST_MATCH`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BetGame`.`CONTEST_MATCH` (
  `MATCH_idMATCH` INT NOT NULL ,
  `CONTEST_idCONTEST` INT NOT NULL ,
  PRIMARY KEY (`MATCH_idMATCH`, `CONTEST_idCONTEST`) ,
  INDEX `fk_MATCH_has_CONTEST_CONTEST1_idx` (`CONTEST_idCONTEST` ASC) ,
  INDEX `fk_MATCH_has_CONTEST_MATCH1_idx` (`MATCH_idMATCH` ASC) ,
  CONSTRAINT `fk_MATCH_has_CONTEST_MATCH1`
    FOREIGN KEY (`MATCH_idMATCH` )
    REFERENCES `BetGame`.`MATCH` (`idMATCH` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_MATCH_has_CONTEST_CONTEST1`
    FOREIGN KEY (`CONTEST_idCONTEST` )
    REFERENCES `BetGame`.`CONTEST` (`idCONTEST` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BetGame`.`GAMER_VIDEOGAME`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BetGame`.`GAMER_VIDEOGAME` (
  `GAMER_idGAMER` INT NOT NULL ,
  `VIDEOGAME_idVIDEOGAME` INT NOT NULL ,
  PRIMARY KEY (`GAMER_idGAMER`, `VIDEOGAME_idVIDEOGAME`) ,
  INDEX `fk_GAMER_has_VIDEOGAME_VIDEOGAME1_idx` (`VIDEOGAME_idVIDEOGAME` ASC) ,
  INDEX `fk_GAMER_has_VIDEOGAME_GAMER1_idx` (`GAMER_idGAMER` ASC) ,
  CONSTRAINT `fk_GAMER_has_VIDEOGAME_GAMER1`
    FOREIGN KEY (`GAMER_idGAMER` )
    REFERENCES `BetGame`.`GAMER` (`idGAMER` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_GAMER_has_VIDEOGAME_VIDEOGAME1`
    FOREIGN KEY (`VIDEOGAME_idVIDEOGAME` )
    REFERENCES `BetGame`.`VIDEOGAME` (`idVIDEOGAME` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `BetGame`.`MATCH_GAMER`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BetGame`.`MATCH_GAMER` (
  `GAMER_idGAMER` INT NOT NULL ,
  `MATCH_idMATCH` INT NOT NULL ,
  `Side` VARCHAR(45) NULL ,
  PRIMARY KEY (`GAMER_idGAMER`, `MATCH_idMATCH`) ,
  INDEX `fk_GAMER_has_MATCH_MATCH1_idx` (`MATCH_idMATCH` ASC) ,
  INDEX `fk_GAMER_has_MATCH_GAMER1_idx` (`GAMER_idGAMER` ASC) ,
  CONSTRAINT `fk_GAMER_has_MATCH_GAMER1`
    FOREIGN KEY (`GAMER_idGAMER` )
    REFERENCES `BetGame`.`GAMER` (`idGAMER` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_GAMER_has_MATCH_MATCH1`
    FOREIGN KEY (`MATCH_idMATCH` )
    REFERENCES `BetGame`.`MATCH` (`idMATCH` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
