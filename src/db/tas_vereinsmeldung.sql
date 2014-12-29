CREATE TABLE IF NOT EXISTS `tas_vereinsmeldung` (
  `turnier_id` int(11) NOT NULL,
  `verein_id` int(11) NOT NULL,
  `anmerkung` text collate utf8_unicode_ci,
  PRIMARY KEY  (`turnier_id`,`verein_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

insert into tas_vereinsmeldung (
`turnier_id`,`verein_id`, `anmerkung` 
)
SELECT distinct 
`turnier_id`,`verein_id`, `anmerkung` 
FROM `tas_meldung` 
WHERE `anmerkung` <> ''
;

ALTER TABLE `tas_meldung` DROP `anmerkung` 
;
