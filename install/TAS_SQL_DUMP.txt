-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2013 at 07:58 PM
-- Server version: 3.23.58
-- PHP Version: 4.4.9


--
-- Database: `db30187`
--

-- --------------------------------------------------------

--
-- Table structure for table `tas_meldung`
--

CREATE TABLE `tas_meldung` (
  `turnier_id` int(11) NOT NULL default '0',
  `spieler_id` int(11) NOT NULL default '0',
  `verein_id` int(11) NOT NULL default '0',
  `ak` varchar(4) NOT NULL default '',
  `anmerkung` varchar(255) default NULL
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Table structure for table `tas_meldung_a`
--

CREATE TABLE `tas_meldung_a` (
  `meldung_id` int(10) unsigned NOT NULL auto_increment,
  `turnier_id` int(11) NOT NULL default '0',
  `spieler_id` int(11) NOT NULL default '0',
  `verein_id` int(11) NOT NULL default '0',
  `ak` varchar(4) NOT NULL default '',
  `anmerkung` varchar(255) default NULL,
  PRIMARY KEY  (`meldung_id`)
) ENGINE=MyISAM AUTO_INCREMENT=672 ;

-- --------------------------------------------------------

--
-- Table structure for table `tas_spieler`
--

CREATE TABLE `tas_spieler` (
  `id` int(11) NOT NULL auto_increment,
  `vorname` varchar(20) NOT NULL default '',
  `nachname` varchar(20) NOT NULL default '',
  `geschlecht` enum('m','w') default NULL,
  `geburtstag` date default NULL,
  `passnummer` varchar(20) default NULL,
  `id_vereine` int(11) default NULL,
  `bemerkung` varchar(30) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2227 ;

-- --------------------------------------------------------

--
-- Table structure for table `tas_turnier`
--

CREATE TABLE `tas_turnier` (
  `id` int(11) NOT NULL auto_increment,
  `name_lang` varchar(160) NOT NULL default '',
  `name_kurz` varchar(40) NOT NULL default '',
  `datum_anmelden_ab` date NOT NULL default '0000-00-00',
  `datum_anmelden_bis` date NOT NULL default '0000-00-00',
  `datum` date NOT NULL default '0000-00-00',
  `ort` varchar(100) NOT NULL default '',
  `email_an` varchar(100) NOT NULL default '',
  `turnierbeauftragter_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=127 ;

-- --------------------------------------------------------

--
-- Table structure for table `tas_turnierbeauftragter`
--

CREATE TABLE `tas_turnierbeauftragter` (
  `id` int(11) NOT NULL auto_increment,
  `nachname` varchar(30) default NULL,
  `vorname` varchar(30) default NULL,
  `strasse` varchar(50) default NULL,
  `plz` varchar(10) default NULL,
  `ort` varchar(50) default NULL,
  `telefon_priv` varchar(30) default NULL,
  `telefon_gesch` varchar(30) default NULL,
  `mobil` varchar(30) default NULL,
  `fax` varchar(30) default NULL,
  `email` varchar(70) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `tas_vereine`
--

CREATE TABLE `tas_vereine` (
  `id` int(11) NOT NULL auto_increment,
  `davor` varchar(20) default NULL,
  `name` varchar(30) NOT NULL default '',
  `kurz` varchar(10) default NULL,
  `passwort` varchar(25) NOT NULL default '',
  `region` varchar(10) default 'NBS',
  `ansprechpartner_email` varchar(100) default NULL,
  `ansprechpartner_name` varchar(50) default NULL,
  `ansprechpartner_strasse` varchar(50) default NULL,
  `ansprechpartner_plz_ort` varchar(50) default NULL,
  `ansprechpartner_telefon` varchar(30) default NULL,
  `ansprechpartner_mobil` varchar(30) default NULL,
  `ansprechpartner_bemerkung` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 ;
