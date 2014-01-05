-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Host: rdbms.strato.de
-- Erstellungszeit: 08. Sep 2013 um 22:51
-- Server Version: 5.5.31-log
-- PHP-Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `DB1226375`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_meldung`
--

DROP TABLE IF EXISTS `tas_meldung`;
CREATE TABLE IF NOT EXISTS `tas_meldung` (
  `turnier_id` int(11) NOT NULL DEFAULT '0',
  `spieler_id` int(11) NOT NULL DEFAULT '0',
  `verein_id` int(11) NOT NULL DEFAULT '0',
  `ak` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `anmerkung` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `tas_meldung`
--

INSERT INTO `tas_meldung` (`turnier_id`, `spieler_id`, `verein_id`, `ak`, `anmerkung`) VALUES
(128, 3, 9, 'U17', ''),
(128, 5, 9, 'U17', ''),
(128, 9, 9, 'U19', ''),
(128, 14, 9, 'U19', ''),
(127, 21, 138, 'U17', 'JD U17: Heimann-Kempf'),
(127, 22, 138, 'U19', 'JD U17: Heimann-Kempf'),
(127, 20, 9, 'U19', ''),
(127, 18, 9, 'U15', ''),
(127, 17, 9, 'U17', ''),
(127, 15, 9, 'U19', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_spieler`
--

DROP TABLE IF EXISTS `tas_spieler`;
CREATE TABLE IF NOT EXISTS `tas_spieler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vorname` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nachname` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `geschlecht` enum('m','w') COLLATE utf8_unicode_ci DEFAULT NULL,
  `geburtstag` date DEFAULT NULL,
  `passnummer` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_vereine` int(11) DEFAULT NULL,
  `bemerkung` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- Daten für Tabelle `tas_spieler`
--

INSERT INTO `tas_spieler` (`id`, `vorname`, `nachname`, `geschlecht`, `geburtstag`, `passnummer`, `id_vereine`, `bemerkung`) VALUES
(1, 'Valentine', 'Amann', 'w', '1998-05-26', 'V-37917', 9, NULL),
(2, 'Paul', 'Bense', 'm', '1999-03-22', 'V-36919', 9, NULL),
(3, 'Peter', 'Bratenstein', 'm', '1999-08-26', 'V-46149', 9, NULL),
(4, 'Marisa', 'De Bellis', 'w', '1995-07-15', 'V-32192', 9, NULL),
(5, 'Julian', 'Dürr', 'm', '1998-05-21', 'V-37077', 9, NULL),
(6, 'Simone', 'Dürr', 'w', '1996-02-11', 'V-32952', 9, NULL),
(7, 'Franziska', 'Eberlein', 'w', '1995-04-19', 'V-32951', 9, NULL),
(8, 'Carina', 'Gröner', 'w', '1996-06-11', 'V-32191', 9, NULL),
(9, 'Johanna', 'Happold', 'w', '1997-06-11', 'V-36921', 9, NULL),
(10, 'Felix', 'Heß', 'm', '1999-02-13', 'V-37418', 9, NULL),
(11, 'Fabio', 'Parrotta', 'm', '1995-01-08', 'V-32768', 9, NULL),
(12, 'Heinrich', 'Pfander', 'm', '1998-12-08', 'V-36920', 9, NULL),
(13, 'Jan-Ruben', 'Schmid', 'm', '1995-07-25', 'V-43789', 9, NULL),
(14, 'Elisa', 'Stauß', 'w', '1996-09-20', 'V-32193', 9, NULL),
(15, 'Lene', 'Stauß', 'w', '1996-08-16', 'V-32190', 9, NULL),
(17, 'Fabian', 'Tegelkamp', 'm', '1998-05-30', 'V-33780', 9, NULL),
(18, 'Evelyn', 'Wiener', 'w', '2001-06-23', 'V-46148', 9, NULL),
(19, 'Wilet', 'Sitthichai', 'm', '1999-12-25', 'V-46147', 9, NULL),
(20, 'Simon', 'Wollandt', 'm', '1997-07-06', 'V-33960', 9, NULL),
(21, 'Patrick', 'Heimann', 'm', '1999-11-29', '05-001764', 138, NULL),
(22, 'Marco', 'Kempf', 'm', '1997-02-21', '05-123456', 138, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_turnier`
--

DROP TABLE IF EXISTS `tas_turnier`;
CREATE TABLE IF NOT EXISTS `tas_turnier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_lang` varchar(160) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name_kurz` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `datum_anmelden_ab` date NOT NULL DEFAULT '0000-00-00',
  `datum_anmelden_bis` date NOT NULL DEFAULT '0000-00-00',
  `datum` date NOT NULL DEFAULT '0000-00-00',
  `ort` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email_an` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `turnierbeauftragter_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=138 ;

--
-- Daten für Tabelle `tas_turnier`
--

INSERT INTO `tas_turnier` (`id`, `name_lang`, `name_kurz`, `datum_anmelden_ab`, `datum_anmelden_bis`, `datum`, `ort`, `email_an`, `turnierbeauftragter_id`) VALUES
(127, '1. Regional-RLT NW Region 1', '', '0000-00-00', '2013-09-27', '2013-10-05', 'Sporthalle Korntal, Martin-Luther-Str. 32', '', 19),
(128, '1. Regional-RLT NW Region 2', '', '0000-00-00', '2013-09-27', '2013-10-05', 'Neue Sporthalle bei der  Realschule, Adlerstr. 73540 Heubach', '', 19),
(129, '1. Regional-RLT NW Region 3', '', '0000-00-00', '2013-09-27', '2013-10-05', 'Staufeneckhalle Staufenecker Str. 42 73084 Salach', '', 19),
(130, '2. Regional-RLT NW Region 1', '', '2013-10-07', '2013-10-11', '2013-10-19', 'Brückentorhalle Beim Brückentor 21 70839 Gerlingen', '', 19),
(131, '2. Regional-RLT NW Region 2', '', '2013-10-07', '2013-10-11', '2013-10-19', 'Mehrzweckh. Gschwend  Hagstr. 26 74417 Gschwend', '', 19),
(132, '2. Regional-RLT NW Region 3', '', '2013-10-07', '2013-10-11', '2013-10-19', 'Sporthalle Bergreute Dobelweg 23 73278 Schlierbach', '', 19),
(133, '3. Regional-RLT NW Region 1', '', '2013-10-20', '2013-11-01', '2013-11-09', 'Stromberg Sporthalle, Schulstr., 75428 Illingen', '', 19),
(134, '3. Regional-RLT NW Region 2', '', '2013-10-20', '2013-11-01', '2013-11-09', 'Wieslaufhalle beim Schulzentrum, Schulstr. 49, 73635 Rudersberg', '', 19),
(136, '3. Regional-RLT NW Region 3', '', '2013-10-20', '2013-11-01', '2013-11-09', 'Sporthalle im Grund, Neuffenstr., 73240 Wendlingen', '', 19);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_turnierbeauftragter`
--

DROP TABLE IF EXISTS `tas_turnierbeauftragter`;
CREATE TABLE IF NOT EXISTS `tas_turnierbeauftragter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nachname` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `vorname` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `strasse` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `plz` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ort` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefon_priv` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefon_gesch` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobil` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Daten für Tabelle `tas_turnierbeauftragter`
--

INSERT INTO `tas_turnierbeauftragter` (`id`, `nachname`, `vorname`, `strasse`, `plz`, `ort`, `telefon_priv`, `telefon_gesch`, `mobil`, `fax`, `email`) VALUES
(19, 'Heß', 'Andreas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sportwart-nw@bwbv.de'),
(20, 'Gall', 'Marcus', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jugendwart-nw@bwbv.de'),
(21, 'Gerdung', 'Michael', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jbr-nw@bwbv.de'),
(22, 'Schmudde', 'Karin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jrr-nw@bwbv.de'),
(23, 'Rattay', 'Carina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jrr-2-nw@bwbv.de'),
(24, 'Wieland', 'Evi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jrr-3-nw@bwbv.de'),
(25, 'Bender', 'Frank', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jugendwart-nb@bwbv.de');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_vereine`
--

DROP TABLE IF EXISTS `tas_vereine`;
CREATE TABLE IF NOT EXISTS `tas_vereine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `davor` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `kurz` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passwort` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `region` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'NBS',
  `ansprechpartner_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ansprechpartner_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ansprechpartner_strasse` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ansprechpartner_plz_ort` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ansprechpartner_telefon` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ansprechpartner_mobil` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ansprechpartner_bemerkung` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=139 ;

--
-- Daten für Tabelle `tas_vereine`
--

INSERT INTO `tas_vereine` (`id`, `davor`, `name`, `kurz`, `passwort`, `region`, `ansprechpartner_email`, `ansprechpartner_name`, `ansprechpartner_strasse`, `ansprechpartner_plz_ort`, `ansprechpartner_telefon`, `ansprechpartner_mobil`, `ansprechpartner_bemerkung`) VALUES
(138, 'KSG', 'Gerlingen', 'Gerlingen', 'Ger199', 'NW', 'jugendwart-nw@bwbv.de', 'Marcus Gall', 'Vesouler Str. 5', '70839 Gerlingen', '07156/23852', '', ''),
(9, 'SV', 'Fellbach', 'Fellbach', 'ahah', 'NW', 'andreas.h.hess@googlemail.com', 'Andreas Heß', 'Bahnhofstr. 80', '70736 Fellbach', '0711 581882', '0173 6558211', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
