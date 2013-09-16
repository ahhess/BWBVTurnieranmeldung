<?php
session_start();

include("config.inc.php");
include("funktionen.inc.php");
include("../adodb/adodb.inc.php");

check_admin_login();

$conn = &ADONewConnection('mysql');	
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

unset($recordSet);
$sql='SELECT * FROM tas_turnierbeauftragter ORDER BY nachname, vorname';
$recordSet = &$conn->Execute($sql);
$liste = $recordSet->getArray();
$conn->Close();

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('liste',$liste);
$smarty->assign('menuakt','turnierbeauftragte.php');
$smarty->assign('admin',$_SESSION["admin"]);
$smarty->display('turnierbeauftragte.tpl.htm');
?>
