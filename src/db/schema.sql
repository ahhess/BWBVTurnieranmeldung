-- phpMyAdmin SQL Dump
-- version 4.2.12
-- http://www.phpmyadmin.net
--
-- Host: rdbms
-- Erstellungszeit: 11. Jan 2015 um 19:46
-- Update: 05. Jun 2019
-- Server Version: 5.5.37-log
-- PHP-Version: 5.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

CREATE TABLE IF NOT EXISTS `tas_meldung` (
  `turnier_id` int(11) NOT NULL DEFAULT '0',
  `spieler_id` int(11) NOT NULL DEFAULT '0',
  `verein_id` int(11) NOT NULL DEFAULT '0',
  `ak` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `partner` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `partner2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bemerkung` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_spieler`
--

CREATE TABLE IF NOT EXISTS `tas_spieler` (
`id` int(11) NOT NULL,
  `vorname` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nachname` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `geschlecht` enum('m','w') COLLATE utf8_unicode_ci DEFAULT NULL,
  `geburtstag` date DEFAULT NULL,
  `passnummer` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_vereine` int(11) DEFAULT NULL,
  `bemerkung` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2918 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_turnier`
--

CREATE TABLE IF NOT EXISTS `tas_turnier` (
`id` int(11) NOT NULL,
  `name_lang` varchar(160) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name_kurz` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `datum_anmelden_ab` date NOT NULL DEFAULT '0000-00-00',
  `datum_anmelden_bis` date NOT NULL DEFAULT '0000-00-00',
  `datum` date NOT NULL DEFAULT '0000-00-00',
  `ort` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email_an` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `turnierbeauftragter_id` int(11) DEFAULT NULL,
  `region` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ausrichterinfos` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meldelliste` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=186 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_turnierbeauftragter`
--

CREATE TABLE IF NOT EXISTS `tas_turnierbeauftragter` (
`id` int(11) NOT NULL,
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
  `region` varchar(10) DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_vereine`
--

CREATE TABLE IF NOT EXISTS `tas_vereine` (
`id` int(11) NOT NULL,
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
  `ansprechpartner_bemerkung` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=10087 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_vereinsmeldung`
--

CREATE TABLE IF NOT EXISTS `tas_vereinsmeldung` (
  `turnier_id` int(11) NOT NULL,
  `verein_id` int(11) NOT NULL,
  `anmerkung` text COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tas_meldung`
--
ALTER TABLE `tas_meldung`
 ADD PRIMARY KEY (`turnier_id`,`spieler_id`);

--
-- Indizes für die Tabelle `tas_spieler`
--
ALTER TABLE `tas_spieler`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tas_turnier`
--
ALTER TABLE `tas_turnier`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tas_turnierbeauftragter`
--
ALTER TABLE `tas_turnierbeauftragter`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tas_vereine`
--
ALTER TABLE `tas_vereine`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `davor` (`davor`,`name`), ADD UNIQUE KEY `kurz` (`kurz`);

--
-- Indizes für die Tabelle `tas_vereinsmeldung`
--
ALTER TABLE `tas_vereinsmeldung`
 ADD PRIMARY KEY (`turnier_id`,`verein_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tas_spieler`
--
ALTER TABLE `tas_spieler`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2918;
--
-- AUTO_INCREMENT für Tabelle `tas_turnier`
--
ALTER TABLE `tas_turnier`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=186;
--
-- AUTO_INCREMENT für Tabelle `tas_turnierbeauftragter`
--
ALTER TABLE `tas_turnierbeauftragter`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT für Tabelle `tas_vereine`
--
ALTER TABLE `tas_vereine`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10087;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
