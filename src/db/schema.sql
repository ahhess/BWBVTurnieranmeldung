-- phpMyAdmin SQL Dump
-- version 2.11.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 05. Januar 2014 um 08:55
-- Server Version: 5.0.51
-- PHP-Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `turnieranmeldung`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_meldung`
--

DROP TABLE IF EXISTS `tas_meldung`;
CREATE TABLE IF NOT EXISTS `tas_meldung` (
  `turnier_id` int(11) NOT NULL default '0',
  `spieler_id` int(11) NOT NULL default '0',
  `verein_id` int(11) NOT NULL default '0',
  `ak` varchar(4) collate utf8_unicode_ci NOT NULL default '',
  `anmerkung` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`turnier_id`,`spieler_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_spieler`
--

DROP TABLE IF EXISTS `tas_spieler`;
CREATE TABLE IF NOT EXISTS `tas_spieler` (
  `id` int(11) NOT NULL auto_increment,
  `vorname` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `nachname` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `geschlecht` enum('m','w') collate utf8_unicode_ci default NULL,
  `geburtstag` date default NULL,
  `passnummer` varchar(20) collate utf8_unicode_ci default NULL,
  `id_vereine` int(11) default NULL,
  `bemerkung` varchar(30) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=654 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_turnier`
--

DROP TABLE IF EXISTS `tas_turnier`;
CREATE TABLE IF NOT EXISTS `tas_turnier` (
  `id` int(11) NOT NULL auto_increment,
  `name_lang` varchar(160) collate utf8_unicode_ci NOT NULL default '',
  `name_kurz` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `datum_anmelden_ab` date NOT NULL default '0000-00-00',
  `datum_anmelden_bis` date NOT NULL default '0000-00-00',
  `datum` date NOT NULL default '0000-00-00',
  `ort` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `email_an` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `turnierbeauftragter_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=139 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_turnierbeauftragter`
--

DROP TABLE IF EXISTS `tas_turnierbeauftragter`;
CREATE TABLE IF NOT EXISTS `tas_turnierbeauftragter` (
  `id` int(11) NOT NULL auto_increment,
  `nachname` varchar(30) character set utf8 collate utf8_unicode_ci default NULL,
  `vorname` varchar(30) character set utf8 collate utf8_unicode_ci default NULL,
  `strasse` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
  `plz` varchar(10) character set utf8 collate utf8_unicode_ci default NULL,
  `ort` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
  `telefon_priv` varchar(30) character set utf8 collate utf8_unicode_ci default NULL,
  `telefon_gesch` varchar(30) character set utf8 collate utf8_unicode_ci default NULL,
  `mobil` varchar(30) character set utf8 collate utf8_unicode_ci default NULL,
  `fax` varchar(30) character set utf8 collate utf8_unicode_ci default NULL,
  `email` varchar(70) character set utf8 collate utf8_unicode_ci default NULL,
  `passwort` varchar(25) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tas_vereine`
--

DROP TABLE IF EXISTS `tas_vereine`;
CREATE TABLE IF NOT EXISTS `tas_vereine` (
  `id` int(11) NOT NULL auto_increment,
  `davor` varchar(20) collate utf8_unicode_ci default NULL,
  `name` varchar(30) collate utf8_unicode_ci NOT NULL default '',
  `kurz` varchar(10) collate utf8_unicode_ci default NULL,
  `passwort` varchar(25) collate utf8_unicode_ci NOT NULL default '',
  `region` varchar(10) collate utf8_unicode_ci default 'NBS',
  `ansprechpartner_email` varchar(100) collate utf8_unicode_ci default NULL,
  `ansprechpartner_name` varchar(50) collate utf8_unicode_ci default NULL,
  `ansprechpartner_strasse` varchar(50) collate utf8_unicode_ci default NULL,
  `ansprechpartner_plz_ort` varchar(50) collate utf8_unicode_ci default NULL,
  `ansprechpartner_telefon` varchar(30) collate utf8_unicode_ci default NULL,
  `ansprechpartner_mobil` varchar(30) collate utf8_unicode_ci default NULL,
  `ansprechpartner_bemerkung` varchar(200) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `davor` (`davor`,`name`),
  UNIQUE KEY `kurz` (`kurz`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=743 ;
