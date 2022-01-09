-- DROP TABLES --
DROP TABLE IF EXISTS `#__ramajax_league_list`;
DROP TABLE IF EXISTS `#__ramajax_league_team_map`;
DROP TABLE IF EXISTS `#__ramajax_use_example`;

-- ************************* CREATE TABLES ************************

-- CREATE TABLE -- Filter field 1
CREATE TABLE `#__ramajax_league_list` (
    `id`       		INT(11)         NOT NULL AUTO_INCREMENT,
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
    `id`       		    INT(11)         NOT NULL AUTO_INCREMENT,
    `league`            VARCHAR(120)    NOT NULL DEFAULT '',
    `team`              VARCHAR(120)    NOT NULL DEFAULT '',
    `player`            VARCHAR(120)    NOT NULL DEFAULT '',
    `player_country`    VARCHAR(120)    NOT NULL DEFAULT '',
    `player_state`      VARCHAR(120)    NOT NULL DEFAULT '',
    `player_city`       VARCHAR(120)    NOT NULL DEFAULT '',
    `wage`              FLOAT           NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
)
    ENGINE =InnoDB
    AUTO_INCREMENT =0
    DEFAULT CHARSET =utf8;

-- ************************* INSERT VALUES ************************

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
('Serie A','Juventus'),
('Serie A','Roma'),
('Serie A','Fiorentina'),
('Premier','Manchester United'),
('Premier','Chelsea'),
('Premier','Arsenal');

-- INSERT VALUES --
INSERT INTO `#__ramajax_use_example` (`league`,`team`,`player`,`player_country`,`player_state`,`player_city`,`wage`) VALUES
('NBA','Phoenix Suns','Charles Barkley','USA','Alabama','Leeds', 1.5),
('NBA','Phoenix Suns','Jerry Colangelo','USA','Illinois','Chicago Heights', 3),
('NBA','Los Angeles Lakers','Russell Westbrook', 'USA','California','Long Beach', 44),
('NBA','Los Angeles Lakers','LeBron James','USA','Ohio','Akron', 41),
('NBA','Golden State Warriors','Stephen Curry','USA','Ohio','Akron', 45),
('NBA','Golden State Warriors','Klay Thompson','USA','California','Los Ángeles', 37),
('LaLiga','Real Madrid','Gareth Bale','UK','Wales','Cardiff', 30),
('LaLiga','Real Madrid','Eden Hazard','Belgium','Wallonia','La Louvière', 20),
('LaLiga','Barcelona','Frenkie de Jong','Netherlands','South_Holland','Gorinchem', 20),
('LaLiga','Barcelona','Sergio Busquets','Spain','Catalonia','Sabadell', 15),
('LaLiga','Celta','Denis Suárez','Spain','Galicia','Salceda de Caselas', 6),
('LaLiga','Celta','Iago Aspas','Spain','Galicia','Moaña', 3),
('Serie A','Juventus','Ramsey','UK','Wales','Caerphilly', 7),
('Serie A','Juventus','Rabiot','France','Île-de-France','Saint-Maurice', 7),
('Serie A','Roma','Lorenzo Pellegrini','Italy','Lazio','Rome', 7),
('Serie A','Roma','Tammy Abraham','UK','London','Camberwell', 7),
('Serie A','Fiorentina','Álvaro Odriozola','Spain','Basque_Country','San Sebastián', 6),
('Serie A','Fiorentina','Lucas Torreira','Uruguay','Río_Negro','Fray Bentos', 4.5),
('Premier','Manchester United','Cristiano Ronaldo','Portugal','Madeira','Funchal', 30),
('Premier','Manchester United','David De Gea','Spain','Madrid','Madrid', 21),
('Premier','Chelsea','Romelu Lukaku','Belgium','Flemish_Region','Antwerp', 21),
('Premier','Chelsea','Timo Werner','Germany','Baden-Württemberg','Stuttgart', 16),
('Premier','Arsenal','Pierre-Emerick Aubameyang','France','Pays_de_la_Loire','Laval', 15),
('Premier','Arsenal','Alexandre Lacazette','France','Auvergne-Rhône-Alpes','Lyon', 11);

