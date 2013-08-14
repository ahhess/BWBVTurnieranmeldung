<?php
session_start();
if (!session_is_registered("verein")) header("location: index.php");

include("config.inc.php");
include("funktionen.inc.php");
include("../adodb/adodb.inc.php");

$conn = &ADONewConnection('mysql');	
$conn->PConnect($host,$user,$password,$database);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

unset($recordSet);
//$sql='SELECT id, davor, name, kurz, passwort, region, ansprechpartner_email FROM tas_vereine ORDER BY name, davor';
$sql='SELECT * FROM tas_vereine ORDER BY region, name, davor';
$recordSet = &$conn->Execute($sql);
$verein=$recordSet->getArray();
//$verein=$verein[0];

require('../smarty/libs/Smarty.class.php');
$smarty = get_new_smarty();
$smarty->assign('verein',$verein);
$smarty->display('vereine.tpl.htm');

$conn->Close();
?>
