-- DROP TABLES --
DROP TABLE IF EXISTS `#__ramajax_definition_tables`;

-- ******************************** NEW FASHION ***************************** --

-- CREATE TABLE --
CREATE TABLE `#__ramajax_definition_tables` (
    `name`              VARCHAR(100)    NOT NULL,
    `extensionName`     VARCHAR(100)    NOT NULL,
    `type`              VARCHAR(100)    NOT NULL,
    `masterFieldName`   VARCHAR(100)    DEFAULT NULL,
    `masterFieldTable`  VARCHAR(100)    DEFAULT NULL,
    `slaveFieldName`    VARCHAR(100)    NOT NULL DEFAULT '',
    `slaveFieldTable`   VARCHAR(100)    NOT NULL DEFAULT '',
    `emptyValueText`    VARCHAR(100)    DEFAULT NULL,
    `datetime`          DATETIME        DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`name`)
)
	ENGINE =InnoDB
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

-- ************************ EXAMPLES *************************** --

-- DROP TABLES --
DROP TABLE IF EXISTS `#__ramajax_league_list`;
DROP TABLE IF EXISTS `#__ramajax_league_team_map`;
DROP TABLE IF EXISTS `#__ramajax_use_example`;

-- ************************* CREATE TABLES ************************

-- CREATE TABLE -- Filter field 1
CREATE TABLE `#__ramajax_league_list` (
    `id`       		INT(11)     NOT NULL AUTO_INCREMENT,
    `league`    VARCHAR(120)    NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
)
	ENGINE =InnoDB
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

-- CREATE TABLE -- Filter field 2
CREATE TABLE `#__ramajax_league_team_map` (
    `id`       		INT(11)         NOT NULL AUTO_INCREMENT,
    `league`    VARCHAR(120)    NOT NULL DEFAULT '',
    `team`      VARCHAR(120)    NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
)
	ENGINE =InnoDB
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

-- CREATE TABLE -- Final Data for the example
CREATE TABLE `#__ramajax_use_example` (
    `id`       		INT(11)         NOT NULL AUTO_INCREMENT,
    `league`        VARCHAR(120)    NOT NULL DEFAULT '',
    `team`          VARCHAR(120)    NOT NULL DEFAULT '',
    `player`        VARCHAR(120)    NOT NULL DEFAULT '',
    `wage`          FLOAT             NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
)
	ENGINE =InnoDB
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;

-- ************************* INSERT VALUES ************************

-- INSERT VALUES --
INSERT INTO `jumer_ramajax_definition_tables` (`name`, `extensionName`, `type`, `masterFieldName`, `masterFieldTable`, `slaveFieldName`, `slaveFieldTable`, `emptyValueText`) VALUES
('team', 'com_ramajaxuseexample', 'ramajaxselect', 'league', '#__ramajax_league_list', 'team', '#__ramajax_league_team_map', 'RAMAJAX_FIELD_SELECT_EMPTY_VALUE_TEXT_TEAM');

-- INSERT VALUES --
INSERT INTO `#__ramajax_league_list` (`league`) VALUES
('NBA'),
('LaLiga'),
('Serie A'),
('Premier');

-- INSERT VALUES --
INSERT INTO `#__ramajax_league_team_map` (`league`,`team`) VALUES
('NBA','Phoenix Suns'),
('NBA','Los Angeles Lakers'),
('NBA','Golden State Warriors'),
('LaLiga','Real Madrid'),
('LaLiga','Barcelona'),
('LaLiga','Celta'),
('Serie A','Juventus '),
('Serie A','Roma'),
('Serie A','Fiorentina'),
('Premier','Manchester United'),
('Premier','Chelsea'),
('Premier','Arsenal');

-- INSERT VALUES --
INSERT INTO `#__ramajax_use_example` (`league`,`team`,`player`,`wage`) VALUES
('NBA','Phoenix Suns','Charles Barkley', 1.5),
('NBA','Phoenix Suns','Jerry Colangelo', 3),
('NBA','Los Angeles Lakers','Russell Westbrook', 44),
('NBA','Los Angeles Lakers','LeBron James',41),
('NBA','Golden State Warriors','Stephen Curry',45),
('NBA','Golden State Warriors','Klay Thompson',37),
('LaLiga','Real Madrid','Gareth Bale',30),
('LaLiga','Real Madrid','Eden Hazard',20),
('LaLiga','Barcelona','Frenkie de Jong',20),
('LaLiga','Barcelona','Sergio Busquets',15),
('LaLiga','Celta','Denis Suárez',6),
('LaLiga','Celta','Iago Aspas',3),
('Serie A','Juventus ','Ramsey',7),
('Serie A','Juventus ','Rabiot',7),
('Serie A','Roma','Lorenzo Pellegrini',7),
('Serie A','Roma','Tammy Abraham',7),
('Serie A','Fiorentina','Álvaro Odriozola',6),
('Serie A','Fiorentina','Lucas Torreira',4.5),
('Premier','Manchester United','Cristiano Ronaldo',30),
('Premier','Manchester United','David De Gea',21),
('Premier','Chelsea','Romelu Lukaku',21),
('Premier','Chelsea','Timo Werner',16),
('Premier','Arsenal','Pierre-Emerick Aubameyang',15),
('Premier','Arsenal','Alexandre Lacazette',11);

