CREATE TABLE IF NOT EXISTS nickchanges (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `oldname` VARCHAR(255) NOT NULL,
  `newname` VARCHAR(255) NOT NULL,
  `puid` VARCHAR(255) NOT NULL,
  `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE INDEX id (id)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci ;

DROP TRIGGER IF EXISTS namechange;

DELIMITER //
CREATE DEFINER = 'dayz'@'localhost' TRIGGER `namechange` BEFORE UPDATE ON Player_DATA
FOR EACH ROW
BEGIN
IF NEW.playername <> OLD.playername THEN
INSERT INTO nickchanges (oldname, newname, puid)
VALUES (OLD.PlayerName, NEW.PlayerName, OLD.PlayerUID);
END IF;
END
//
DELIMITER ;
