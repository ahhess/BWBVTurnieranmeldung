-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: rdbms
-- Erstellungszeit: 05. Jan 2014 um 09:13
-- Server Version: 5.5.31-log
-- PHP-Version: 5.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `DB1226375`
--
CREATE DATABASE IF NOT EXISTS `DB1226375` DEFAULT CHARACTER SET latin1 COLLATE latin1_german1_ci;
USE `DB1226375`;

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
  `anmerkung` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`turnier_id`,`spieler_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=712 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=142 ;

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
  `passwort` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `davor` (`davor`,`name`),
  UNIQUE KEY `kurz` (`kurz`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=426 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
