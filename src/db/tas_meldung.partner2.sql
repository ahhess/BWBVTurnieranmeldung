alter  TABLE `tas_meldung` add (
  `partner2` varchar(100) collate utf8_unicode_ci default NULL,
  `bemerkung` varchar(100) collate utf8_unicode_ci default NULL
  );
update `tas_meldung` set `bemerkung` = `partner`;
update `tas_meldung` set `partner` = null;
