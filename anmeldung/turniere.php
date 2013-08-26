<?php
session_start();

include("config.inc.php");
include("funktionen.inc.php");
include("../adodb/adodb.inc.php");

check_login();

$conn = &ADONewConnection('mysql');	
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

unset($recordSet);
$sql='SELECT tas_turnier.*, tas_turnierbeauftragter.nachname, tas_turnierbeauftragter.vorname 
	FROM tas_turnier
	LEFT OUTER JOIN tas_turnierbeauftragter 
		ON tas_turnier.turnierbeauftragter_id = tas_turnierbeauftragter.id 
	ORDER BY datum desc, name_lang';
$recordSet = &$conn->Execute($sql);
$liste = $recordSet->getArray();
$conn->Close();

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('liste',$liste);
$smarty->assign('menuakt','turniere.php');
$smarty->display('turniere.tpl.htm');
?>
